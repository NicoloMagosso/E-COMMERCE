<?php

require '../../models/classes.php';

session_start();

$products = Product::fetchAll();
?>

<html>
<head>
    <title>Catalogo Prodotti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            width: 300px;
        }

        li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        form {
            margin-top: 10px;
        }

        input {
            padding: 5px;
            margin-right: 5px;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #45a049;
        }

    </style>
</head>

<body>

<?php foreach ($products as $product) { ?>
    <ul>
        <li><?php echo $product->getMarca() ?></li>
        <li><?php echo $product->getNome() ?></li>
        <li><?php echo $product->getPrezzo() ?></li>
    </ul>

    <form action="../../actions/add_to_cart.php" method="POST">
        <input type="number" name="quantita" placeholder="quantita">
        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
        <input type="submit" value="Aggiungi al carrello">
    </form>
<?php } ?>

<?php include '../navbar.php'; ?>

<a href="../carts/index.php">Vai al carrello</a>


</body>
</html>

