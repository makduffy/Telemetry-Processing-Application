<?php

namespace Telemetry\Models;
use Doctrine\ORM\Mapping as ORM;

class MessageData
{
    private $id;
    private $sourceMSISDN;
    private $destinationMSISDN;
    private $receivedTime;
    private $bearer;
    private $messageRef;
    private $message;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSourceMSISDN(): string
    {
        return $this->sourceMSISDN;
    }

    public function setSourceMSISDN(string $sourceMSISDN): self
    {
        $this->sourceMSISDN = $sourceMSISDN;
        return $this;
    }

    public function getDestinationMSISDN(): string
    {
        return $this->destinationMSISDN;
    }

    public function setDestinationMSISDN(string $destinationMSISDN): self
    {
        $this->destinationMSISDN = $destinationMSISDN;
        return $this;
    }

    public function getReceivedTime(): \DateTime
    {
        return $this->receivedTime;
    }

    public function setReceivedTime(\DateTime $receivedTime): self
    {
        $this->receivedTime = $receivedTime;
        return $this;
    }

    public function getBearer(): string
    {
        return $this->bearer;
    }

    public function setBearer(string $bearer): self
    {
        $this->bearer = $bearer;
        return $this;
    }

    public function getMessageRef(): int
    {
        return $this->messageRef;
    }

    public function setMessageRef(int $messageRef): self
    {
        $this->messageRef = $messageRef;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }
}