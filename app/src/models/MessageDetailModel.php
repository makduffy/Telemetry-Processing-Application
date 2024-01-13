<?php
declare (strict_types=1);

namespace Telemetry\models;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;


class MessageDetailModel
{
    private $logger;
    private $entityManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function __destruct()
    {}

    public function storeMessageData() : void
    {

    }
}