<?php

namespace Telemetry\Support;

class SQLQueries
{
    public function __construct(){ }

    public function __destruct(){ }

    public function insertMessage()
    {
        $query_string = "INSERT INTO telemetry_data ";
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
        $query_String = "SELECT FROM tblUsers ";
        $query_String .= "WHERE ";
        $query_String .= "email = :login_email ";
        $query_String .= "AND ";
        $query_String .= "password = :login_password";
        return $query_String;
    }

    public function displayMessage(){
        
    }

}