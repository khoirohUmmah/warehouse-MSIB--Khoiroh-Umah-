<?php
class Database{
    private $host = "127.0.0.1";
    private $port = "3306";
    private $db_name = "warehouse_msib";
    private $username = "root";
    private $password = "root";
    public $conn;

    public function getConnection(){
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name;port=$this->port", $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $err) {
            echo "Connection failed: " . $err->getMessage();
        }

        return $this->conn;
    }
}

$database = new Database();
$database->getConnection();
?>
