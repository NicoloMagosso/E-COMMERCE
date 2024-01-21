<?php

require '../models/Classes.php';

$email = $_POST['email'];
$password = $_POST['password'];
$password_confirmation = $_POST['password-confirmation'];

//Verifica se le password coincidono
if (strcmp($password, $password_confirmation) != 0) {
    // Se le password non coincidono, reindirizza l'utente alla pagina di registrazione
    header('Location:../views/signup.php');
    exit;
}

//Hash della password con l'algoritmo SHA-256 prima di salvarla nel database
$password = hash('sha256', $password);

$pdo = DbManager::Connect("ecommerce");

//Verifica se l'utente con la stessa email esiste già
$stmt = $pdo->prepare("SELECT id FROM ecommerce.users WHERE email = :email LIMIT 1");
$stmt->bindParam(":email", $email);
$stmt->execute();

//Cerca se l'utente è presente nel database
$user = $stmt->fetchObject("User");

//Se l'utente non esiste, procedi con la creazione del nuovo utente
if (!$user) {
    $params = ['email' => $email, 'password' => $password];
    $user = User::Create($params);

    //Se la creazione dell'utente ha successo, crea un carrello associato ad esso
    if ($user) {
        Cart::Create($user->GetID());

        header('Location:../views/login.php');
        exit();
    } else {

        header('Location:../views/signup.php');
        exit();
    }
} else {
    //Se l'utente con la stessa email esiste già, reindirizza l'utente alla pagina di registrazione
    header('Location:../views/signup.php');
    exit();
}
?>