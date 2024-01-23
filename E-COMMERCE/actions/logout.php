<?php

require '../models/Classes.php';

session_start();

$user = $_SESSION['current_user'];

if ($user) {
    $session_obj = $_SESSION['object_session'];

    $current_time = date("Y-m-d H:i:s");
    $session_obj->setDataLogout($current_time);
    $session_obj->setFinished(1);

    $session_obj->Update();

    $_SESSION['current_user'] = null;
    $_SESSION['object_session'] = null;

    header('location:../views/login.php');
    exit;
}
?>
