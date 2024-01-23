<?php ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<table>
    <tr>
        <td>
            <form action="../actions/login.php" method="post">
                <h2 style="text-align: center;">Login</h2>
                <input type="text" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Invio">
            </form>
        </td>
    </tr>
    <tr>
        <td>
            <p style="text-align: center; margin-top: 10px;">
                <a>Non sei ancora iscritto <a href="../views/signup.php">clicca qui!</a>
            </p>
        </td>
    </tr>
</table>
</body>

</html>