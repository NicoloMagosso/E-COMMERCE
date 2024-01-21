<?php

require '../../models/classes.php';

session_start();

$products = Product::fetchAll();
$user = $_SESSION['current_user'];
?>

<html>
<head>
    <title>Catalogo</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e6f7ff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }

        .product-container {
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            width: 300px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            width: 100%;
        }

        li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        form {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #66b3ff;
            border-radius: 4px;
        }

        input[type="number"] {
            background-color: #f2f2f2;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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

        h2 {
            text-align: center;
            color: #007bff;
        }

        .navbar {
            margin-top: 20px;
            text-align: center;
        }

    </style>
</head>

<body>

<?php foreach ($products as $product) { ?>
    <div class="product-container">
        <ul>
            <li><?php echo $product->getMarca() ?></li>
            <li><?php echo $product->getNome() ?></li>
            <li><?php echo $product->getPrezzo() ?></li>
        </ul>

        <form action="../../actions/add_to_cart.php" method="POST">
            <input type="number" name="quantita" placeholder="Quantità">
            <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
            <input type="submit" value="Aggiungi al carrello">
        </form>
    </div>
<?php } ?>
<table>
    <div class="navbar">
        <tr>
            <td>
                <?php include '../navbar.php'; ?>
            </td>

        </tr>
    </div>
    <div>
        <tr>
            <td>
                <a href="../carts/index.php">Vai al carrello</a>
            </td>
        </tr>
    </div>
</table>

</body>
</html>
