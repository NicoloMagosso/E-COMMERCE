<?php ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e6f7ff;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #66b3ff;
            border-radius: 4px;
        }

        input[type="email"],
        input[type="password"],
        input[type="password-confirmation"] {
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

        h2 {
            text-align: center;
            color: #007bff;
        }
    </style>
</head>

<body>
<table>
    <tr>
        <td>
            <form action="../actions/signup.php" method="post">
                <h2>Sign Up</h2>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password-confirmation" placeholder="Conferma Password" required>
                <input type="submit" value="Invio">
            </form>
        </td>
    <tr>
        <td>
            <p style="text-align: center; margin-top: 10px;">
                Se sei già iscritto <a href="../views/login.php";>clicca qui!</a>.
            </p>
        </td>

</body>

</html>