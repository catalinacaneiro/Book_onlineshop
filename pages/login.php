<?php

require_once("utils/validaring.php");
require_once("repositories/userRepository.php");


$db = new Database();
$userRepo = new UserRepository($db->pdo);



$v = new Validator($_POST);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $v->field('email')->required()->email();
    $v->field('password')->required();



    if ($v->is_valid()) {
        try {
            $userRepo->loginUser(
                $_POST['email'],
                $_POST['password']
            );
            header("Location: /");
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
    <title>Login</title>
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
            <h1>Login</h1>


            <?php
            $formAction = "";
            $buttonText = "Login";


            require("components/loginForm.php");
            ?>


        </div>
    </section>

    <footer>
        <?php require_once("components/footer.php"); ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
</body>