<?php
declare (strict_types=1);

namespace Telemetry\Support;

use PDO;
use PDOException;
use function Telemetry\trigger_error;
use function Telemetry\var_dump;

class DatabaseWrapper
{
    private $database_handle;
    private $sql_queries;
    private $stmt;
    private $errors;
    private $log;

    public function __construct()
    {
        $this->database_handle = null;
        $this->sql_queries = null;
        $this->prepared_statement = null;
        $this->errors = [];
        $this->database_connection_messages = [];
    }
    public function __destruct(){
    }

    public function setDatabaseHandle($database_handle): void
    {
        $this->database_handle = $database_handle;
    }

    public function setSQLQueries($sql_queries): void
    {
        $this->sql_queries = $sql_queries;
    }

    public function setLogger($log): void
    {
        $this->log=$log;
    }
    private function safeQuery($query_string, $params = null)
    {
        $query_parameters = $params;

        $this->database_handle->setAttribute(PDO::AFTER_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->prepared_statement = $this->database_handle->prepare($query_string);
        $execute_result = $this->prepared_statement->execute($params);
        $this->database_connection_messages['execute-OK'] = $execute_result;

    }

    public function countRows(){
        return $this->prepared_statement->rowCount();
    }

    public function safeFetchRow(){
        return $this->prepared_statement->fetch(PDO::FETCH_NUM);
    }

    public function safeFetchArray(){
        $row = $this->prepared_statement->fetch(PDO::FETCH_ASSOC);
        $this->prepared_statement->closeCursor();
        return $row;
    }

}