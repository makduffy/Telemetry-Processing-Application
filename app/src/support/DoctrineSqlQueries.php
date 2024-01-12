<?php
/**
 * class to contain all database access using Doctrine's QueryBulder
 *
 * A QueryBuilder provides an API that is designed for conditionally constructing a DQL query in several steps.
 *
 * It provides a set of classes and methods that is able to programmatically build queries, and also provides
 * a fluent API.
 * This means that you can change between one methodology to the other as you want, or just pick a preferred one.
 *
 * From https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html
 */

namespace Telemetry\Support;

class DoctrineSqlQueries
{
    public function __construct(){}

    public function __destruct(){}


    public static function queryStoreTelemetryData(
        object $queryBuilder,
        int $heater_data,
        string $fan_data,
        int $keypad_data,
        bool $switch1_data,
        bool $switch2_data,
        bool $switch3_data,
        bool $switch4_data
    )
    {
        $store_result = [];

        $qb = $queryBuilder->insert('telemetry_data')
            ->values(
                [
                    'heater_data' => ':heater_data',
                    'fan_data' => ':fan_data',
                    'keypad_data' => ':keypad_data',
                    'switch1_data' => ':switch1_data',
                    'switch2_data' => ':switch2_data',
                    'switch3_data' => ':switch3_data',
                    'switch4_data' => ':switch4_data'


                ]
            )
            ->setParameters(
                [
                    'heater_data' => $heater_data,
                    'fan_data' => $fan_data,
                    'keypad_data' => $keypad_data,
                    'switch1_data' => $switch1_data,
                    'switch2_data' => $switch2_data,
                    'switch3_data' => $switch3_data,
                    'switch4_data' => $switch4_data,
                ]
            );

        $store_result['outcome'] = $qb->execute();
        $store_result['sql_query'] = $qb->getSQL();

        return $store_result;
    }

    public static function queryRetrieveTelemetryData(object $queryBuilder, array $criteria) {
        $qb = $queryBuilder->select('*')
            ->from('telemetry_data');

        foreach ($criteria as $key => $value) {
            $qb->andWhere($qb->expr()->eq($key, ':' . $key))
                ->setParameter($key, $value);
        }
        $query = $qb->execute();
        return $query->fetchAll();
    }

    public static function queryStoreMessageDetails(
        object $queryBuilder,
        string $sourceMSISDN,
        string $destinationMSISDN,
        \DateTime $receivedTime,
        string $bearer,
        int $messageRef,
        string $message
    )
    {
        $store_result = [];

        $qb = $queryBuilder->insert('message_details')
            ->values(
                [
                    'sourceMSISDN' => ':sourceMSISDN',
                    'destinationMSISDN' => ':destinationMSISDN',
                    'receivedTime' => ':receivedTime',
                    'bearer' => ':bearer',
                    'messageRef' => ':messageRef',
                    'message' => ':message'
                ]
            )
            ->setParameters(
                [
                    'sourceMSISDN' => $sourceMSISDN,
                    'destinationMSISDN' => $destinationMSISDN,
                    'receivedTime' => $receivedTime->format('Y-m-d H:i:s'),
                    'bearer' => $bearer,
                    'messageRef' => $messageRef,
                    'message' => $message
                ]
            );

        $store_result['outcome'] = $qb->execute();
        $store_result['sql_query'] = $qb->getSQL();

        return $store_result;
    }


    /*public static function queryRetrieveTelemetryData(
        object $queryBuilder,
        int $heater_data
    )
    {
        $retrieve_result = [];
        $qb = $queryBuilder
            ->select('*')
            ->from('telemetry_data')
            ->where('heater_data = :heater_data')
            ->setParameter('heater_data', $heater_data);

        $query = $qb->execute();
        $result = $query->fetchAll();

        return $result;
    } */
}
