<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request-form</title>
    <link rel="shortcut icon" href="../image/logo.jpg" type="image/x-icon">
    <style>
        body {
            background-color: #000;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }

        .container form {
            padding: 30px;
            background-color: #009EFA;
        }

        .container form h2 {
            text-align: center;
        }

        .container form table tbody tr td {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 5px;
            width: 100%;
        }

        .container form table tbody tr td input,
        .container form table tbody tr td textarea {
            color: #000;
            outline: none;
            padding: 5px;
            width: 100%;
        }

        .container form table tbody tr td button {
            background-color: #FFC75F;
            border: none;
            padding: 5px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <h2>Request-Form</h2>
            <table>
                <tbody>
                    <tr>
                        <td><input type="text" name="rname" placeholder="Enter your name"></td>
                    </tr>
                    <tr>
                        <td><input type="email" name="remail" placeholder="Enter your email address"></td>
                    </tr>
                    <tr>
                        <td><textarea name="rtext" cols="30" rows="10" placeholder="Enter your request"></textarea></td>
                    </tr>
                    <tr>
                        <td><input type="phone" name="rphone" placeholder="Enter your phone number"></td>
                    </tr>
                    <tr>
                        <td><button name="submit">Request</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>