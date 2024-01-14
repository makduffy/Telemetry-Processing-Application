<?php
declare (strict_types=1);

namespace Telemetry\models;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Telemetry\Models\TelemetryDetailModel;

class MessageDetailModel
{
    private $logger;
    private $entity_manager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entity_manager)
    {
        $this->logger = $logger;
        $this->entity_manager = $entity_manager;
    }

    public function __destruct()
    {}

    public function storeMessageData($sourceMSISDN, $destinationMSISDN, $bearer, $messageRef, $message) : void
    {
        $message_data = new MessageData();

        if ($sourceMSISDN !== null){
            $message_data->setSourceMSISDN($sourceMSISDN);
        }
        if ($destinationMSISDN !== null){
            $message_data->setDestinationMSISDN($destinationMSISDN);
        }
        if ($bearer !== null){
            $message_data->setBearer($bearer);
        }
        if ($messageRef !== null){
            $message_data->setMessageRef($messageRef);
        }
        if ($message !== null){
            $message_data->setMessage($message);
        }

        $this->entity_manager->persist($message_data);
        $this->entity_manager->flush();
    }

    public function getLatestMessageData()
    {
        try {
            $query = $this->entity_manager->createQueryBuilder()
                ->select('data')
                ->from(MessageData::class, 'data')
                ->orderBy('data.receivedTime', 'DESC')
                ->setMaxResults(1)
                ->getQuery();

            return $query->getOneOrNullResult();

        } catch (\Exception $e) {
            $this->logger->error("Error fetching latest message data " . $e->getMessage());
            return null;
        }
    }

    public function processMessageData($xml_string): array {
        $xml = new \SimpleXMLElement($xml_string);


        $messageSourcemsisdn = (string)$xml->sourcemsisdn;
        $messageDestinationmsisdn = (string)$xml->destinationmsisdn;
        $messagebearer = (string)$xml->bearer;
        $messageref = (string)$xml->messageref;
        $messageData_content = (string)$xml->message;

        $processedMetaData = [
            'sourcemsisdn' => $messageSourcemsisdn,
            'destinationmsisdn' => $messageDestinationmsisdn,
            'receivedTime' => (string)$xml->receivedtime,
            'bearer' => $messagebearer,
            'messageref' => $messageref,
            'message' => $messageData_content,
            'messagetype' => (string)$xml->messageType, // Assuming messageType is a string
        ];

        var_dump($processedMetaData);

        return $processedMetaData;
    }

}