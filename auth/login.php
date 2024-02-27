<?php
    if ($_POST) {
        require_once '../model/autorun.php';
        $myModel = Model\Data::makeModel(Model\Data::FILE);
        if($user = $myModel->readUser($_POST['username'])) {
            if($user->checkPassword($_POST['password'])) {
                session_start();
                $_SESSION['user'] = $user->getUserName();
                header('Location: ../index.php');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/login-style.css">
    <title>Authentication</title>
    <body>
    <form class="login-container" method="post">
        <h2>Log In</h2>
        <p>
            <input class="login-input" type="text" name="username" placeholder="Username">
        </p>
        <p>
            <input class="login-input" type="password" name="password" placeholder="Password">
        </p>
        <p>
            <input class="login-button" type="submit" value="Log in">
        </p>
        <div class="login-link">
            <a href="#">Forgot Password?</a>
        </div>
    </form>
</body>
</html>