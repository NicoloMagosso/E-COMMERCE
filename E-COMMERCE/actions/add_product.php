<?php

require '../models/Classes.php';

session_start();

$product = Product::Create($_POST);

header('Location: ../views/admin/index.php');

?>