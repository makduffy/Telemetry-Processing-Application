<?php

declare (strict_types=1);

namespace Telemetry\Support;

use function DI\string;

class Validator
{
    public function __construct(){ }

    public function __deconstruct(){ }

    public function validateFanData($fan_data){
        
    }

    public function validateHeaterData($heater_data)
    {

    }

    public function validateSwitchData($switch_data){

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
    public function sanitizeData($telemetry_data)
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
}