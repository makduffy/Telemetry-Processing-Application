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
    private ?int $id;
    /**@ORM\Column (type="string") */
    private ?string $sourceMSISDN;
    /**@ORM\Column (type="string")*/
    private ?string $destinationMSISDN;
    /**@ORM\Column (type="datetime") */

   //private ?string $receivedTime;
   // /**@ORM\Column (type="string") */

    private ?string $bearer;
    /**@ORM\Column (type="string") */
    private ?string $messageRef;
    /**@ORM\Column (type="string")*/
    private ?string $message;
    /** @ORM\Column (type="datetime") */
    private ?\DateTime  $created_at;
    /** @ORM\Column (type="datetime") */
    public function __construct() {
        $this->created_at = new \DateTime();
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
   /** public function getReceivedTime(): string
    {
        return $this->receivedTime;
    }
    public function setReceivedTime(string $receivedTime): self
    {
        $this->receivedTime = $receivedTime;
        return $this;
    }
    */
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
    public function getCreatedAt(): \DateTime {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self {
        $this->created_at = $created_at;
        return $this;
    }
}