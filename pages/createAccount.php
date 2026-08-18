<?php

require_once("utils/validaring.php");
require_once("repositories/userRepository.php");


$db = new Database();
$userRepo = new UserRepository($db->pdo);



$v = new Validator($_POST);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $v->field('username')->required()->alpha_num([' '])->min_len(3)->max_len(50);
    $v->field('email')->required()->email();
    $v->field('password')->required()->min_len(6);
    $v->field('confirm_password', 'Confirm password')->equals($_POST['password'] ?? '');


    if ($v->is_valid()) {
        try {
            $userRepo->addUser(
                $_POST['email'],
                $_POST['password'],
                $_POST['username']
            );
            header("Location: /login");
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Edit Product</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <nav>
        <?php require_once("components/nav.php"); ?>
    </nav>

    <section>
        <div class="container px-4 px-lg-5 mt-5">
            <h1>Register</h1>
            <form method="POST" class="card p-4 shadow-sm">
               
                <?php
                $formAction = "";
                $buttonText = "Create Account";


                require("components/user.form.php");
                ?>

            </form>