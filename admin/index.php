<?php
include "php/config.php";
session_start();

if (isset($_SESSION['username'])) {
    header("Location: $url/admin/php/dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="../image/logo.jpg" type="image/x-icon">
    <title>Admin-Login</title>
</head>

<body>
    <div class="container-fluid">
        <header>
            <div class="heading">
                <div><img src="../image/logo.jpg" alt="#"></div>
                <h1>Book-Wala</h1>
            </div>
            <div class="admin">
                <h2>Admin-Panel</h2>
            </div>
            <div class="buttons">
                <span><a href="form.php" target="_blank">Request</a></span>
            </div>
        </header>
    </div>
    <div class="login-form">
        <div class="form-info">
            <?php
            if (isset($_POST['submit'])) {
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $password = mysqli_real_escape_string($conn,sha1($_POST['password']));

                $select = "select Admin_id,Admin_first_name,Admin_email,Admin_password,Admin_designation,status from admin where Admin_email = '{$email}' and Admin_password = '{$password}' and status= 1";

                $queary = mysqli_query($conn, $select) or die(mysqli_error($conn) . "login failed");

                if (mysqli_num_rows($queary) > 0) {
                    try {
                        while ($row = mysqli_fetch_assoc($queary)) {
                            $_SESSION['uid'] = $row['Admin_id'];
                            $_SESSION['username'] = $row['Admin_first_name'];
                            $_SESSION['designation'] = $row['Admin_designation'];
                        }
                        if($_SESSION['designation'] == "pickup executive" || $_SESSION['designation'] == "delivery executive"){
                            header("Location: $url/admin/php/excutive.php");
                        }else{
                            header("Location: $url/admin/php/dashboard.php");
                        }
                    } catch (exception $err) {
                        header('Location: $url/admin');
                    }
                } else {
                    echo "<h4 id='check' align='center'>Invalid Credentials.</h4>";
                }
            }
            ?>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <h3>Login</h3>
                <div>
                    <input type="email" name="email" id="email" placeholder="Email id*" required>
                </div>
                <div>
                    <input type="password" name="password" id="password" placeholder="Password*" required>
                </div>
                <div align="center">
                    <button name="submit" id="login">login</button>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <p>All rights reserved by <a href="#">krishna</a></p>
    </footer>
    <script src="js/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function() {
            let email = $("#email").val();
            let password = $("#password").val();
            $("#login").on('click', function(e) {
                if (email == "" || password == "") {
                    $("#email, #password").css({
                        "border-bottom": "2px solid red"
                    });
                }
            });
        });
    </script>
</body>

</html>