<?php
require '../../models/Classes.php';

session_start();

if (!isset($_SESSION['current_user'])) {
    http_response_code(401); // Set HTTP response code to 401 (Unauthorized)
    echo "404 - Unauthorized Access";
    exit;
}

// Recupera l'utente corrente e il carrello a lui associato
$current_user = $_SESSION['current_user'];
$carrello = Cart::Find($current_user->GetID());
$prodotti = $carrello->FetchAllProducts();

?>

<html>
<head>
    <title>Carrello</title>
    <link rel="stylesheet" href="../style2.css">
    <?php include '../navbar.php'; ?>
</head>

<body>
<?php if ($carrello) : ?>
    <h1>Carrello</h1>
    <table>
        <?php foreach ($prodotti as $productInCart) : ?>
            <?php if ($productInCart['quantita'] != 0) { ?>
                <?php $prodotto = Product::Find($productInCart['product_id']); ?>
                <tr>
                <td>
                <div class="product-container" id= <?php echo $prodotto->getId(); ?>>

                <!--DETTAGLI PRODOTTO-->
                <ul>
                    <li><?php echo $prodotto->getNome(); ?></li>
                    <li><?php echo $prodotto->getMarca(); ?></li>
                    <li><?php echo $prodotto->getPrezzo(); ?>$</li>
                    <li>Quantità: <?php echo $productInCart['quantita']; ?></li>
                    <li>Totale: <?php echo $productInCart['quantita'] * $prodotto->getPrezzo(); ?></li>
                </ul>

                <!--MODIFICA QUANTITA-->
                <form action="../../actions/edit_cart.php" method="POST">
                    <label for="quantita">Modifica quantità:</label>
                    <input type="number" name="quantita" value="<?php echo $productInCart['quantita']; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $prodotto->getId(); ?>">
                    <input type="submit" name="update" value="Aggiorna quantità">
                </form>

                <!--RIMUOVERE-->
                <form action="../../actions/edit_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $prodotto->getId(); ?>">
                    <input type="hidden" name="quantita" value="0">
                    <input type="submit" name="remove" value="Rimuovi dal carrello">
                </form>
            <?php } ?>
            </div>
            </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!--TOTALE-->
    <p>Totale carrello: <?php echo $carrello->getTotalPrice(); ?>$</p>
    <form action="../../actions/edit_cart.php" method="POST">
        <input type="number" name="quantita" value="<?php echo $carrello->getQuantita(); ?>">
        <input type="hidden" name="id" value="<?php echo $carrello->getId(); ?>">
        <input type="submit" value="Compra">
    </form>

<?php else : ?>
    <p>Il carrello è vuoto.</p>
<?php endif ?>

</body>

</html>