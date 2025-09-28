<?php
class Database {
    private $servername = "localhost";
    private $username   = "root";   // default in XAMPP
    private $password   = "";       // default in XAMPP
    private $dbname     = "book";   // use your actual database name

    protected $conn;

    public function connect() {
        $this->conn = new PDO(
            "mysql:host=$this->servername;dbname=$this->dbname",
            $this->username,
            $this->password
        );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->conn;
    }
}
