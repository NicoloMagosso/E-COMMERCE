<?php

require '../models/Classes.php';

session_start();

// Ottieni l'oggetto utente corrente dalla sessione
$user = $_SESSION['current_user'];

// Definisce un array con 'product_id' e 'quantita' ottenuti dalla richiesta POST
$params = ['product_id' => $_POST['product_id'], 'quantita' => $_POST['quantita']];

// Trova il carrello dell'utente corrente
$cart = Cart::Find($user->getId());

// Verifica se il carrello esiste già o ne crea uno nuovo
if (!$cart) {
    // Se il carrello non esiste, crea un nuovo carrello
    $cart = Cart::Create($user->getId());
}

// Aggiorna o aggiungi il prodotto al carrello
$cart->AddProductToCart($params);

header('Location: ../views/products/index.php');
exit();
?>