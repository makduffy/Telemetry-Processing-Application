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

    public function processMessageData($xml_string): array {
        $xml = new \SimpleXMLElement($xml_string);


        $messageSourcemsisdn = (string)$xml->sourcemsisdn;
        $messageDestinationmsisdn = (string)$xml->destinationmsisdn;
        $messagebearer = (string)$xml->bearer;
        $messageref = (string)$xml->messageref;
        $message_data_content = (string)$xml->message;

        $processedMetaData = [
            'sourcemsisdn' => $messageSourcemsisdn,
            'destinationmsisdn' => $messageDestinationmsisdn,
            'bearer' => $messagebearer,
            'messageref' => $messageref,
            'message' => $message_data_content,
            'messagetype' => (string)$xml->messageType,
        ];

        return $processedMetaData;
    }

    public function isMessageDataNew($received_time): bool {

        $latest_data = $this->getLatestMessageData();
        if (!$latest_data) {
            return true;
        }
        $latest_timestamp = $latest_data->getReceivedTime();
        return $received_time > $latest_timestamp;
    }

    public function getLatestMessageData()
    {
        try {
            $query = $this->entity_manager->createQueryBuilder()
                ->select('m')
                ->from(MessageData::class, 'm')
                ->orderBy('m.created_at', 'DESC')
                ->setMaxResults(1)
                ->getQuery();

            return $query->getOneOrNullResult();

        } catch (\Exception $e) {
            $this->logger->error("Error fetching latest message data: " . $e->getMessage());
            return null;
        }
    }
}