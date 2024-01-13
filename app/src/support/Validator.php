<?php

declare (strict_types=1);

namespace Telemetry\Support;

use function DI\string;

class Validator
{
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function validateFanData($fan_data)
    {
        if ($this->fanDataStored) {
            return null;
        }

        $matches = [];

        // Use a regular expression to match the word "fan" and a few characters after it
        if (preg_match('/fan\w*/i', $fan_data, $matches)) {
            // $matches[0] will contain the matched string (word "fan" and following characters)
            return $matches[0];
        }

        return null;
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
            // Check if the item contains the identifier
            if (is_string($item) && str_contains($item, $identifier)) {
                $filteredData[] = $item;
            }
        }

        if (empty($filteredData)) {
            // Handle the case when no matching items are found
            return [];
        }

        // Get the latest item in the filtered array
        $latestData = [end($filteredData)];
        var_dump($latestData);
        return $latestData;
    }


    public function sanitizeData($telemetry_data)
    {
        if (is_array($telemetry_data)) {
            $cleaned_data = '';
            foreach ($telemetry_data as $item) {
                $xml = new \SimpleXMLElement($item);

                foreach ($xml->message as $message) {
                    $cleaned_data .= (string)$message . ' ';
                }
            }
            return trim($cleaned_data);
        } elseif (is_string($telemetry_data)) {
            $xml = new \SimpleXMLElement($telemetry_data);
            $cleaned_data = '';

            foreach ($xml->message as $message) {
                $cleaned_data .= (string)$message . ' ';
            }
            return trim($cleaned_data);
        } else {
            return '';
        }
    }
}
    //public function sanitizeData($data)
    // {
    //   if (is_array($data)) {
    //      $result = '';
//
    //      foreach ($data as $item) {
    //          if (preg_match('/<message>(.*?)<\/message>/', $item, $matches)) {
    //           $result .= $matches[1] . ' '; // Concatenate the matched messages
    //           }
    //     }

    //      return trim($result); // Remove trailing space and return a single string
    ///    } elseif (is_string($data)) {
    //        if (preg_match('/<message>(.*?)<\/message>/', $data, $matches)) {
    //           return $matches[1]; // Return the matched message from the input string
    //      } else {
    //           return ''; // Return an empty string if no match is found
    //       }
    //    } else {
    //       return ''; // Return an empty string for unsupported input types
    //    }
    // }
