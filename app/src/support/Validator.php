<?php

declare (strict_types=1);

namespace Telemetry\Support;

use function DI\string;

class Validator
{
    public function __construct(){ }

    public function __deconstruct(){ }

    public function validateFanData($fan_data)
    {
    }
    public function validateHeaterData($heater_data)
    {
    }
    public function validateSwitchData($switch_data)
    {
    }
    public function validateKeypadData($keypad_data)
    {
    }
    public function filterArray(array $telemetry_data, $identifier): array
    {
        $filteredData = [];

        foreach ($telemetry_data as $item) {
            if (str_contains($item, $identifier)) {
                $filteredData[] = $item;
            }
        }
        return $filteredData;
    }

    public function sanitizeData($xmlString, $type){
        $sanitizedMessages = [];

        try{
            $xml = new \SimpleXMLElement($xmlString);

            foreach ($xml->message as $message) {
                if ((string)$message->type === $type) {
                    $filteredMessages[] = [
                        'id' => (string)$message->id,
                        'content' => (string)$message->content
                    ];
                }
            }
        } catch (\Exception $e) {
        }
        return $sanitizedMessages;
    }

    public function filterData(object $validator, array $telemetry_data): array
    {

        $sanitized_data = [];

        $fan_data = $telemetry_data['fan'] ?? null;
        $heater_data = $telemetry_data['heater'] ?? null;
        $keypad_data = $telemetry_data['keypad'] ?? null;
        $switch1_data = $telemetry_data['switch1'] ?? null;
        $switch2_data = $telemetry_data['switch2'] ?? null;
        $switch3_data = $telemetry_data['switch3'] ?? null;
        $switch4_data = $telemetry_data['switch4'] ?? null;

        $sanitized_data['fan_data'] = $validator->sanitizeData($fan_data);
        $sanitized_data['heater_data'] = $validator->sanitizeData($heater_data);
        $sanitized_data['keypad_data'] = $validator->sanitizeData($keypad_data);
        $sanitized_data['switch1_data'] = $validator->sanitizeData($switch1_data);
        $sanitized_data['switch2_data'] = $validator->sanitizeData($switch2_data);
        $sanitized_data['switch3_data'] = $validator->sanitizeData($switch3_data);
        $sanitized_data['switch4_data'] = $validator->sanitizeData($switch4_data);

        return $sanitized_data;
    }





    /*public function sanitizeData($telemetry_data)
    {
        if (is_array($telemetry_data))
        {
            $cleaned_data = '';
            foreach ($telemetry_data as $item)
            {
                $xml = new \SimpleXMLElement($item);

                foreach ($xml->message as $message)
                {
                    $cleaned_data  .= (string)$message . ' ';
                }
            }
            return trim($cleaned_data );
        } elseif (is_string($telemetry_data))
        {
            $xml = new \SimpleXMLElement($telemetry_data);
            $cleaned_data  = '';

            foreach ($xml->message as $message)
            {
                $cleaned_data  .= (string)$message . ' ';
            }
            return trim($cleaned_data );
        } else {
            return '';
        }
    }
    */

}