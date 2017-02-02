<?php

require_once 'inc/classDB.php';
require_once 'inc/clases/user_class.php';
require_once 'inc/sesion.php';

$user = new User();

if ($user->getUser($_POST["user"], $_POST["pass"])) {
    $_SESSION['username'] = $_POST['user'];
    setcookie("member_login", $_POST["user"], time() + (7 * 24 * 60 * 60));
    setcookie("member_password", $_POST["pass"], time() + (7 * 24 * 60 * 60));
    echo 1;
} else {
    echo 0;
}
?>