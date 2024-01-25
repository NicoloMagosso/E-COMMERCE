<?php

require '../models/Classes.php';

session_start();

$user = $_SESSION['current_user'];
$product_id = $_POST['product_id'];
$quantita = $_POST['quantita'];

//Trova il carrello dell'utente
$carrello = Cart::Find($user->GetID());

if ($quantita > 0) {
    //Se la quantità è maggiore di zero, crea un array di parametri e aggiorna il prodotto nel carrello
    $params = ['product_id' => $product_id, 'quantita' => $quantita];
    $carrello->updateProduct($params);
} else {
    //Rimuove il prodotto dal carrello
    $carrello->removeProduct($product_id);
}

header('Location: ../views/carts/index.php');
exit;
?>