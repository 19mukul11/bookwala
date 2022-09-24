<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>pickup</title>
</head>

<body>
    <div class="container-fluid">
        <header>
            <div class="heading">
                <div><img src="../../image/logo.jpg" alt="#"></div>
                <h1>Book-Wala</h1>
            </div>
            <div class="admin">
                <h2>Admin-Panel</h2>
            </div>
            <div class="buttons">
                <span>
                    <p><?php echo $_SESSION['username']; ?><button id="hide">Logout</button></p>
                </span>
            </div>
        </header>
    </div>
    <div id="tables" class="excutive" align="right">
    </div>
    <div class="view">
        <div class="view-contant">
            <button class="close-button"><i class="fa-solid fa-xmark"></i></button>
            <div class="view-data"></div>
        </div>
    </div>
    <script src="../js/jquery-3.6.0.js"></script>
    <script src="../js/script.js"></script>

    <body>

</html>