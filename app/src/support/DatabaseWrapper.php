<?php
declare (strict_types=1);

namespace Telemetry\Support;

use PDO;
use PDOException;
use function Telemetry\trigger_error;
use function Telemetry\var_dump;

class DatabaseWrapper
{
    private $database_connection_settings;
    private $db_handle;
    private $sql_queries;
    private $prepared_statement;
    private $log;
    private $errors;

    public function __construct(){
        $this->database_connection_settings = null;
        $this->db_handle = null;
        $this->sql_queries = null;
        $this->prepared_statement = null;
        $this->log=null;
        $this->errors = [];
    }

    public function __deconstruct(){
    }

    public function setDatabaseConnectionSettings($database_connection_settings){
        $this->database_connection_settings = $database_connection_settings;
    }

    public function setSQLQueries($sql_queries){
        $this->sql_queries = $sql_queries;
    }

    public function setLogger($log){
        $this->log=$log;
    }

    public function makeDatabaseConnection(){
        $pdo_error = '';

        $database_settings = $this->database_connection_settings;
        $host_name = $database_settings['rdbms'] . ':host=' . $database_settings['host'];
        $port_number = ';port=' . '3306';
        $user_database = ';dbname=' . $database_settings['db_name'];
        $host_details = $host_name . $port_number . $user_database;
        $user_name = $database_settings['user_password'];
        $user_password = $database_settings['user_password'];
        $pdo_attributes = $database_settings['options'];

        try {
            $pdo_handle = new PDO($host_details, $user_name, $user_password, $pdo_attributes);
            $this->db_handle = $pdo_handle;
            $this->log->notice('Successfully connected to database');
        } catch (PDOException $exception_object) {
            trigger_error('error connecting to databse');
            $pdo_error = 'error connecting to database';
            $this->log->warning('Error connecting to database');
        }

        return $pdo_error;
    }

    /**
     * @param $query_string
     * @param null $params
     *
     * The values to be bound are passed in the $params array to the execute method.
     *
     * @return mixed
     */

    private function safeQuery($query_string, $params = null){
        $this->errors['db_error'] = false;
        $query_parameters = $params;

        try{

        }catch (PDOException $exception_object){
            $error_message = 'PDO Exception caught. ';
            $error_message .= 'Error with the database access.' . "\n";
            $error_message .= 'SQL Query: ' . $query_string . "\n";
            $error_message .= 'Error: ' . var_dump($this->prepared_statement->errorInfo(),true) . "\n";
            $this->errors['db_error'] = true;
            $this->errors['sql_error'] = $error_message;
            $this->session_logger->warning('Error connecting to database');
        }
        return $this->erorrs['db_error'];
    }

    public function countRows(){
        $num_rows = $this->prepared_statement->rowCount();
        return $num_rows;
    }

    public function safeFetchRow(){
        $record_set = $this->prepared_statement->fetch(PDO::FETCH_NUM);
        return $record_set;
    }

    public function safeFetchArray(){
        $row = $this->prepared_statement->fetch(PDO::FETCH_ASSOC);
        $this->prepared_statement->closeCursor();
        return $row;
    }

}