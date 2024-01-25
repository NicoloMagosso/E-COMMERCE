<?php
require '../../models/Classes.php';

session_start();

if (!isset($_SESSION['current_user'])) {
    http_response_code(401);
    echo "401 - Unauthorized Access";
    exit;
}

$current_user = User::Find($_SESSION['current_user']->getId());

if ($current_user->getRole_ID() != 2) {
    http_response_code(401);
    echo "401 - Unauthorized Access";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../style2.css">
    <?php include '../navbar.php'; ?>
</head>
<body>
<h2>Crea Prodotto</h2>
<form action="../../actions/add_product.php" method="POST">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required><br>

    <label for="prezzo">Prezzo:</label>
    <input type="number" id="prezzo" name="prezzo" step="0.01" required><br>

    <label for="marca">Marca:</label>
    <input type="text" id="marca" name="marca" required><br>

    <input type="submit" value="Crea Prodotto">
</form>
</body>
</html>