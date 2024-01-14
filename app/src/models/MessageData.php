<?php

namespace Telemetry\Models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */

class MessageData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column (type="string")
     */
    private $sourceMSISDN;
    /**
     * @ORM\Column (type="string")
     */
    private $destinationMSISDN;
    /**
     * @ORM\Column (type="string")
     */
    private $bearer;
    /**
     * @ORM\Column (type="string")
     */
    private $messageRef;
    /**
     * @ORM\Column (type="string")
     */
    private $message;
    /**
     * @ORM\Column (type="datetime")
     */
    private \DateTime $receivedTime;

    public function __construct() {
        $this->receivedTime = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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
    
    public function getBearer(): string
    {
        return $this->bearer;
    }
    public function setBearer(string $bearer): self
    {
        $this->bearer = $bearer;
        return $this;
    }
    public function getMessageRef(): string
    {
        return $this->messageRef;
    }
    public function setMessageRef(string $messageRef): self
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
    public function setReceivedTime(\DateTime $receivedTime): self
    {
        $this->receivedTime = $receivedTime;
        return $this;
    }

    public function getReceivedTime(): \DateTime
    {
        return $this->receivedTime;
    }

    /**
     * @ORM\PrePersist
     */

}