<?php

namespace Sts\Models\Helpers;

use PDO;

class Con
{
    private string $dbPort;
    private string $dbHost;
    private string $dbName;
    private string $dbUser;
    private string $dbPasswd;

    private object $connect;


    public function __construct()
    {
        $this->dbPort = $_ENV['DB_PORT'];
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbName = $_ENV['DB_DATABASE'];
        $this->dbUser = $_ENV['DB_USERNAME'];
        $this->dbPasswd = $_ENV['DB_PASSWORD'];


        $this->checkConnection();
        $this->configConnection();
    }

    public function connect()
    {
        return $this->getConnection();
    }

    private function checkConnection()
    {
        try {
            $this->connect = new PDO("mysql:dbname={$this->dbName};host={$this->dbHost};port={$this->dbPort}", $this->dbUser, $this->dbPasswd);
        } catch (\PDOException $err) {
            die($err->getMessage());
        }
    }

    private function configConnection()
    {
        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function getConnection(): object
    {
        return $this->connect;
    }

}