<?php

require '../../models/classes.php';

session_start();

$products = Product::fetchAll();

if (!isset($_SESSION['current_user'])) {
    http_response_code(401);
    echo "401 - Unauthorized Access";
    exit;
}

$user = $_SESSION['current_user'];

?>

<html>
<head>
    <title>Catalogo</title>
    <link rel="stylesheet" href="../style2.css">
    <?php include '../navbar.php'; ?>
</head>

<body>
<h1>Prodotti</h1>
<table>
    <?php foreach ($products as $product) { ?>
        <tr>
            <td>
                <div class="product-container">
                    <ul>
                        <li><?php echo $product->getNome() ?></li>
                        <li><?php echo $product->getMarca() ?></li>
                        <li><?php echo $product->getPrezzo() ?>$</li>
                    </ul>

                    <form action="../../actions/add_to_cart.php" method="POST"
                          name="form<?php echo $product->getId(); ?>">
                        <input type="number" name="quantita" placeholder="0">
                        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                        <input type="submit" value="Aggiungi al carrello">
                    </form>
                </div>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
