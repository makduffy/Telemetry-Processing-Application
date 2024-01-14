<?php

namespace Telemetry\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /** @ORM\Column(type="string") */
    private string $username;

    /** @ORM\Column(type="string") */
    private string $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    public function __construct(){
        $this->createdAt = new \DateTime();
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function setCreatedTime(\DateTime $createdAt): self{
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedTime(): \DateTime {
        return $this->createdAt;
    }
}

