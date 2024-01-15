<?php

require '../models/Classes.php';

//Inizia o ripristina la sessione utente
session_start();

//Ottieni l'oggetto utente corrente dalla sessione
$user = $_SESSION['current_user'];

//Trova il carrello dell'utente corrente utilizzando il metodo statico Find della classe Cart
$cart = Cart::Find($user->GetID());

//Definisce un array di parametri con 'product_id' e 'quantita' ottenuti dalla richiesta POST
$params = ['product_id' => $_POST['product_id'], 'quantita' => $_POST['quantita']];

//Verifica se il carrello esiste già o ne crea uno nuovo
if (!$cart) {
    $cart->updateProduct($params);
} else {
    $cart->AddProductToCart($params);
}

header('Location: ../views/products/index.php');
exit();
?>