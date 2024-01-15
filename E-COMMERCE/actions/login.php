<?php

require '../models/Classes.php';

session_start();

//Ottieni i dati dal file login.php
$email = $_POST["email"];
$password = hash('sha256', $_POST["password"]);

$pdo = DbManager::Connect("ecommerce");

//Prepara la query per selezionare l'utente corrispondente
$stmt = $pdo->prepare("SELECT id, email, password FROM ecommerce.users WHERE email = :email AND password = :password LIMIT 1");
$stmt->bindParam(":email", $email);
$stmt->bindParam(":password", $password);

$stmt->execute();

//Ottieni l'utente come un oggetto
$user = $stmt->fetchObject("User");

//Verifica se l'utente esiste
if (!$user) {
    header('location:../views/login.php');
    exit;
} else {
    //Se l'utente esiste, imposta la sessione corrente con l'utente autenticato
    $_SESSION['current_user'] = $user;

    //Crea un array con i parametri per la sessione e crea un oggetto Session
    $params = array('ip' => $_SERVER["REMOTE_ADDR"], 'data_login' => date('d/m/y H:i'));
    $_SESSION['object_session'] = Session::Create($params);

    header('location:../views/products/index.php');
    exit;
}
?>
