<?php

namespace Telemetry\Support;

class SQLQueries
{
    public function __construct(){ }

    public function __destruct(){ }

    public function insertMessage()
    {
        $query_string = "INSERT INTO tblTelemetry_Data ";
        $query_string .= "SET ";
        $query_string .= "msisdn = 447452835992";
        $query_string .= "target_msisdn = :target_msisdn";
        $query_string .= "date = :message_date";
        $query_string .= "message = :parsed_message";
        return $query_string;
    }

    public function addUser()
    {
        $query_String = "INSERT INTO tblUsers ";
        $query_String .= "SET ";
        $query_String .= "email = :register_email, ";
        $query_String .= "password = :registered_password, ";
        $query_String .= "user_msisdn = :registered_msisdn, ";
        $query_String .= "active = true";

        return $query_String;
    }

    public function insertTelemetry()
    {
        $query_String = "INSERT INTO tblTelemetry ";
        $query_String .= "SET ";
        $query_String .= "switch_01 = :sanitised_switch01";
        $query_String .= "switch_02 = :sanitised_switch02";
        $query_String .= "switch_03 = :sanitised_switch03";
        $query_String .= "switch_04 = :sanitised_switch04";
        $query_String .= "fan = :sanitised_fan";
        $query_String .= "heater = :sanitised_heater";
        $query_String .= "keypad = :sanitised_keypad";
        return $query_String;
    }

    public function displayTelemetry()
    {
        $query_String = "SELECT * FROM tblTelemetry ";
        return $query_String;
    }

    public function getLatestTelemetry()
    {
        $query_String = "SELECT * FROM tblTelemetry ";
        $query_String .= "ORDER BY ";
        $query_String .= "date DESC";
        $query_String .= "LIMIT 1";
        return $query_String;
    }

    public function toString(array $Array)
    {
        return ("Switch 1= $Array[0] Sqitch ");
    }

    public function deleteUser()
    {
        $query_String = "DELETE FROM tblUsers ";
        $query_String .= "WHERE ";
        $query_String .= "email = :delete_email ";
        $query_String .= "AND ";
        $query_String .= "password = :delete_password";
        return $query_String;
    }

    public function getUser()
    {
        $query_String = "SELECT * FROM tblUsers ";
        $query_String .= "WHERE ";
        $query_String .= "email = :login_email ";
        $query_String .= "AND ";
        $query_String .= "password = :login_password";
        return $query_String;
    }

    public function displayMessage(){
        $query_String = "SELECT * FROM tbltelemetry_data";

        return $query_String;
    }

    public function  getLatestMessage()
    {
        $query_String = "SELECT * FROM tbltelemetry_data";
        $query_String .= "ORDER BY ";
        $query_String .= "date DESC";
        $query_String .= "LIMIT 1";
        return $query_String;
    }



}