<?php
require_once("vendor/autoload.php");

class Database {
    public $pdo;
    public $host; 
    public $db; 
    public $user;
    public $pass; 
    public $port; 

    
    function __construct(){
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
 
        $host = $_ENV['DATABASE_HOST'];
        $db = $_ENV['DATABASE_NAME'];
        $user = $_ENV['DATABASE_USER'];
        $pass = $_ENV['DATABASE_PASSWORD'];
        $port = $_ENV['DATABASE_PORT'];

        $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4";
        $this->pdo = new PDO($dsn, $user, $pass); 
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    function getPdo() {
        return $this->pdo;
    }

}
?>