<?php

declare (strict_types=1);

namespace Telemetry\models;

use Doctrine\DBAL\DriverManager;

class RegisterUserModel
{

    public function __construct(){}

    public function __destruct() { }


    function cleanupParameters(object $validator, array $tainted_parameters): array
    {
        $cleaned_parameters = [];

        $tainted_username = $tainted_parameters['username'];
        $tainted_userage = $tainted_parameters['userage'];
        $tainted_email = $tainted_parameters['email'];
        $tainted_requirements = $tainted_parameters['requirements'];

        $cleaned_parameters['password'] = $tainted_parameters['password'];
        $cleaned_parameters['sanitised_username'] = $validator->sanitiseString($tainted_username);
        $cleaned_parameters['validated_userage'] = $validator->validateInt($tainted_userage);
        $cleaned_parameters['sanitised_email'] = $validator->sanitiseEmail($tainted_email);
        $cleaned_parameters['sanitised_requirements'] = $validator->sanitiseString($tainted_requirements);
        return $cleaned_parameters;
    }


    function encrypt(object $libsodium_wrapper, array $cleaned_parameters): array
    {
        $encrypted = [];
        $encrypted['encrypted_username_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_username']);
        $encrypted['encrypted_userage_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['validated_userage']);
        $encrypted['encrypted_email_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_email']);
        $encrypted['encrypted_dietary_requirements_and_nonce'] = $libsodium_wrapper->encrypt($cleaned_parameters['sanitised_requirements']);

        return $encrypted;
    }

    function encode(object $base64_wrapper, array $encrypted_data): array
    {
        $encoded = [];
        $encoded['encoded_username'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_username_and_nonce']['nonce_and_encrypted_string']);
        $encoded['encoded_userage'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_userage_and_nonce']['nonce_and_encrypted_string']);
        $encoded['encoded_email'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_email_and_nonce']['nonce_and_encrypted_string']);
        $encoded['encoded_requirements'] = $base64_wrapper->encode_base64($encrypted_data['encrypted_dietary_requirements_and_nonce']['nonce_and_encrypted_string']);
        return $encoded;
    }

    /**
     * Uses the Bcrypt library with constants from settings.php to create hashes of the entered password
     *
     * @param $app
     * @param $password_to_hash
     * @return string
     */
    function hash_password(object $bcrypt_wrapper, string $password_to_hash, array $settings): string
    {
        $hashed_password = $bcrypt_wrapper->createHashedPassword($password_to_hash, $settings);
        return $hashed_password;
    }

    /**
     * function both decodes base64 then decrypts the extracted cipher code
     *
     * @param $libsodium_wrapper
     * @param $base64_wrapper
     * @param $encoded
     * @return array
     */
    function decrypt(object $libsodium_wrapper, object $base64_wrapper, array $encoded): array
    {
        $decrypted_values = [];

        $decrypted_values['username'] = $libsodium_wrapper->decrypt(
            $base64_wrapper,
            $encoded['encoded_username']
        );

        $decrypted_values['email'] = $libsodium_wrapper->decrypt(
            $base64_wrapper,
            $encoded['encoded_email']
        );

        $decrypted_values['dietary_requirements'] = $libsodium_wrapper->decrypt(
            $base64_wrapper,
            $encoded['encoded_requirements']
        );

        return $decrypted_values;
    }

    /**
     *
     * Uses the Doctrine QueryBuilder API to store the sanitised user data.
     *
     * @param array $cleaned_parameters
     * @param string $hashed_password
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    function storeUserDetails(
        array $database_connection_settings,
        object $doctrine_queries,
        array $cleaned_parameters,
        string $hashed_password
    ): string
    {
        $storage_result = [];
        $store_result = '';

        $database_connection = DriverManager::getConnection($database_connection_settings);

        $queryBuilder = $database_connection->createQueryBuilder();

        $storage_result = $doctrine_queries::queryStoreUserData($queryBuilder, $cleaned_parameters, $hashed_password);

        if ($storage_result['outcome'] == 1)
        {
            $store_result = 'User data was successfully stored with the Doctrine ORM using the SQL query: ' . $storage_result['sql_query'];
        }
        else
        {
            $store_result = 'There appears to have been a problem when saving your details.  Please try again later.';

        }
        return $store_result;
    }
}
