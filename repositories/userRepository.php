<?php
require_once("Models/user.php");
require 'vendor/autoload.php';


class UserRepository
{
    private PDO $pdo;
    private $auth;
    function getAuth()
    {
        return $this->auth;
    }

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->auth = new \Delight\Auth\Auth($pdo);
    }

    function setupUser()
    {

    }

   function seedUsers()
{
    try {
        $userId = $this->auth->admin()->createUser(
            "test@test.se",
            "Test123!",
            "testuser"
        );

        echo "Användare skapad med ID: " . $userId;
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        echo "Användaren finns redan";
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        echo "Ogiltig e-postadress";
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        echo "Ogiltigt lösenord";
    }
}

 function addUser($email, $password, $username)
{
    try {
        $userId = $this->auth->register(
            $email,
            $password,
            $username
        );

        return $userId;
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        echo "Ivalid email adress";
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        echo "Invalid password";
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        echo "User already exists";
    }
}


}