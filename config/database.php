<?php
require_once("vendor/autoload.php");

class Database
{
    public $pdo;
    public $host;
    public $db;
    public $user;
    public $pass;
    public $port;


    function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $host = trim($_ENV['DATABASE_HOST'] ?? '127.0.0.1');
        $db = trim($_ENV['DATABASE_NAME'] ?? '');
        $user = trim($_ENV['DATABASE_USER'] ?? '');
        $pass = trim($_ENV['DATABASE_PASSWORD'] ?? '');
        $port = trim($_ENV['DATABASE_PORT'] ?? '3306');

        if ($host === 'localhost') {
            $host = '127.0.0.1';
        }

        $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    function getPdo()
    {
        return $this->pdo;
    }

}
?>