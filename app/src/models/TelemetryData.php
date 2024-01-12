<?php

namespace Telemetry\Models;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class TelemetryData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;
    /** @ORM\Column (type="string") */
    private string $fan_data;
    /** @ORM\Column (type="string") */
    private string $heater_data;
    /** @ORM\Column (type="string") */
    private string $switch1_data;
    /** @ORM\Column (type="string") */
    private string $switch2_data;
    /** @ORM\Column (type="string") */
    private string $switch3_data;
    /** @ORM\Column (type="string") */
    private string $switch4_data;
    /** @ORM\Column (type="string") */
    private string $keypad_data;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFanData(): string
    {
        return $this->fan_data;
    }

    public function setFanData(string $fan_data): self
    {
        $this->fan_data = $fan_data;
        return $this;
    }

    public function getHeaterData(): string
    {
        return $this->heater_data;
    }

    public function setHeaterData(string $heater_data): self
    {
        $this->heater_data = $heater_data;
        return $this;
    }

    public function getSwitch1Data(): string
    {
        return $this->switch1_data;
    }

    public function setSwitch1Data(string $switch1_data): self
    {
        $this->switch1_data = $switch1_data;
        return $this;
    }

    public function getSwitch2Data(): string
    {
        return $this->switch2_data;
    }

    public function setSwitch2Data(string $switch2_data): self
    {
        $this->switch2_data = $switch2_data;
        return $this;
    }

    public function getSwitch3Data(): string
    {
        return $this->switch3_data;
    }

    public function setSwitch3Data(string $switch3_data): self
    {
        $this->switch3_data = $switch3_data;
        return $this;
    }

    public function getSwitch4Data(): string
    {
        return $this->switch4_data;
    }

    public function setSwitch4Data(string $switch4_data): self
    {
        $this->switch4_data = $switch4_data;
        return $this;
    }

    public function getKeypadData(): string
    {
        return $this->keypad_data;
    }

    public function setKeypadData(string $keypad_data): self
    {
        $this->keypad_data = $keypad_data;
        return $this;
    }
}