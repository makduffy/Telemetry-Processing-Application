<?php

namespace Telemetry\models;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class UserDetailModel
{
    private $logger;
    private $entity_manager;
    public function __construct(LoggerInterface $logger, EntityManagerInterface $entity_manager)
    {
        $this->logger = $logger;
        $this->entity_manager = $entity_manager;
    }

    public function __destruct(){}

    public function storeUserData($username, $password){
        $user_data = new UserData();

        if ($username !== null){
            $user_data->setUsername($username);
        }
        if ($password !== null){
            $user_data->setPassword($password);
        }

        $this->entity_manager->persist($user_data);
        $this->entity_manager->flush();
    }

    public function hashPassword($password){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $hashedPassword;
    }

    public function authenticate($username, $password)
    {
        // Find user by username
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user->getPassword())) {
            return true; // Authentication successful
        }

        return false; // Authentication failed
    }

}