<?php
class MyConnection
{
    private $server, $username, $password, $database;
    private $connection;

    public function __construct($server, $username, $password, $database)
    {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connectDB()
    {
        $this->connection = new mysqli($this->server, $this->username, $this->password, $this->database);
        if ($this->connection->connect_error) {
            die("Kết nối đến MySQL thất bại: " . $this->connection->connect_error);
        }
    }

}