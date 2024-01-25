<?php

require '../models/Classes.php';

session_start();

//Verifica se l'ID del prodotto è stato fornito nella richiesta POST
if (!isset($_POST['id'])) {
    http_response_code(400);
    echo "400 - Bad Request. Product ID is missing.";
    exit;
}

//Ottieni l'ID del prodotto dalla richiesta POST
$product_id = Product::Find($_POST['id']);

//Elimina il prodotto utilizzando il metodo Delete della classe Product
if ($product_id->delete($_POST)) {
    echo "Prodotto eliminato con successo.";
    header('Location: ../views/admin/index.php');
} else {
    http_response_code(500);
    echo "500 - Internal Server Error. Impossibile eliminare il prodotto.";
}
?>