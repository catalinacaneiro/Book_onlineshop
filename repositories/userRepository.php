<?php
require_once("Models/user.php");

class UserRepository
{
    private PDO $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }




}