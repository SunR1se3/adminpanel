<?php

class DB {
    private $conn;

    public function __construct() {
        $serverName = "localhost"; //serverName\instanceName
        $connectionInfo = array( "Database"=>"AdminPanel");
        $this->conn = sqlsrv_connect($serverName, $connectionInfo);

        if (!$this->conn) {
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function SqlExec($sql) {
        $stmt = sqlsrv_query($this->conn, $sql);
        if ($stmt === false) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function Select($sql) {
        $stmt = sqlsrv_query($this->conn, $sql);
        if ($stmt === false) {
            die( print_r( sqlsrv_errors(), true));
        }

        return $stmt;
    }

    public function CloseConnection() {
        sqlsrv_close($this->conn);
    }
}