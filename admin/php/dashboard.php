<?php
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: $url/admin");
}if($_SESSION['designation'] == 'pickup executive' || $_SESSION['designation'] == 'delivery executive'){
    session_unset();
    session_destroy();
    header("Location: $url/admin");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../../image/logo.jpg" type="image/x-icon" />
    <title>Admin-Panel</title>

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
                <?php
                if ($_SESSION['designation'] == "admin") {
                    echo "<span><button id='add-btn'>Add-Admin</button></span>
                ";
                }
                ?>
                <span>
                    <p><?php echo $_SESSION['username']; ?><button id="hide">Logout</button></p>
                </span>
            </div>
        </header>
    </div>
    <div class="add-admin">
        <div class="form-info">
            <button id="close"><i class="fa-solid fa-xmark"></i></button>
            <form>
                <h3>Admin-Sign Up</h3>
                <div>
                    <input type="text" placeholder="Enter admin first Name" id="fname" required>
                </div>
                <div>
                    <input type="text" placeholder="Enter admin last Name" id="lname" required>
                </div>
                <div>
                    <input type="email" placeholder="Enter admin email" id="email" required>
                </div>
                <div>
                    <input type="phone" placeholder="Enter admin phone number" id="phone" required>
                </div>
                <div id="degination"></div>
                <div>
                    <input type="password" placeholder="Enter password" id="password" required>
                </div>
                <div hidden id="error-form">
                    *
                </div>
                <div>
                    <input type="password" placeholder="Enter confirm password" id="cpassword" required>
                </div>
                <div hidden id="error-form-c">
                    *
                </div>
                <div align="center">
                    <button id="add-admin">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div class="add-book"></div>
    <nav>
        <div class="links">
            <ul id="main-list">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="#">Book</a>
                    <div class="sublist">
                        <ul>
                            <li><a href="#" id="add-book">Add-Book</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="#">DataBase</a>
                    <div class="sublist">
                        <ul>
                            <?php
                            $result = mysqli_query($conn, "select Admin_id,Admin_designation from admin where Admin_id = '{$_SESSION['uid']}'") or die(mysqli_error($conn) . 'Admin degination error in nav');
                            $row = mysqli_fetch_assoc($result);
                            if ($row['Admin_designation'] == 'admin') {
                                echo "
                                        <li id='customer'><a href='#'>Customer</a></li>
                                        <li id='book'><a href='#'>Store</a></li>
                                        <li id='book-i'><a href='#'>Inventory</a></li>
                                        <li id='order'><a href='#'>Buy-Order</a></li>
                                        <li id='orders'><a href='#'>Sell-Order</a></li>
                                        <li id='payment-b'><a href='#'>Payment buy</a></li>
                                        <li id='payment-s'><a href='#'>Payment sell</a></li>
                                    ";
                            } else if ($row['Admin_designation'] == 'store manager') {
                                echo "
                                        <li id='book'><a href='#'>Store</a></li>
                                        <li id='book-i'><a href='#'>Inventory</a></li>
                                    ";
                            } else if ($row['Admin_designation'] == 'order manager') {
                                echo "
                                        <li id='order'><a href='#'>Buy-Order</a></li>
                                        <li id='orders'><a href='#'>Sell-Order</a></li>
                                        <li id='order'><a href='#'>History</a></li>
                                    ";
                            } else if ($row['Admin_designation'] == 'payment') {
                                echo "
                                        <li id='customer'><a href='#'>Active-Order</a></li>
                                        <li id='book'><a href='#'>Completed-Order</a></li>
                                        <li id='book'><a href='#'>History</a></li>
                                        <li id='payment'><a href='#'>Payment</a></li>
                                    ";
                            }
                            ?>
                        </ul>
                    </div>
                </li>
                <li><?php
                        if ($row['Admin_designation'] == 'admin') {
                            echo "<a href='#'>Profile</a>
                                    <div class='sublist'>
                                        <ul>
                                            <li><a href='#' id='admin-profile'>Admin-profile</a></li>
                                            <li><a href='#'>Accounts</a></li>
                                            <li><a href='#'>Manager</a></li>
                                            <li><a href='#'>Book-Inventry_officer</a></li>
                                            <li><a href='#'>Book-Store_manager</a></li>";
                        }
                    ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="search">
            <form>
                <input type="text" id="search" placeholder="Search by Id only">
                <button id="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </nav>
    <section>
        <div class="contant">
            <div id="table-head">
                <div class="count">
                    <h3>Customer</h3>
                    <?php
                    $query = mysqli_query($conn, "select * from customer") or die(mysqli_error($conn) . "count error");
                    $count = mysqli_num_rows($query);
                    if ($count > 0) {
                        echo "<p>{$count}</p>";
                    } else {
                        echo "<p>0</p>";
                    }
                    ?>
                </div>
                <div class="count">
                    <h3>Admin</h3>
                    <?php
                    $query = mysqli_query($conn, "select * from admin") or die(mysqli_error($conn) . "count error");
                    $count = mysqli_num_rows($query);
                    if ($count > 0) {
                        echo "<p>{$count}</p>";
                    } else {
                        echo "<p>0</p>";
                    }
                    ?>
                </div>
                <div class="count">
                    <h3>Book-In-Store</h3>
                    <?php
                    $query = mysqli_query($conn, "select * from book where Book_location= 1") or die(mysqli_error($conn) . "count error");
                    $count = mysqli_num_rows($query);
                    if ($count > 0) {
                        echo "<p>{$count}</p>";
                    } else {
                        echo "<p>0</p>";
                    }
                    ?>
                </div>
                <div class="count">
                    <h3>Book-In-Inventory</h3>
                    <?php
                    $query = mysqli_query($conn, "select * from book where Book_location = 0") or die(mysqli_error($conn) . "count error");
                    $count = mysqli_num_rows($query);
                    if ($count > 0) {
                        echo "<p>{$count}</p>";
                    } else {
                        echo "<p>0</p>";
                    }
                    ?>
                </div>
                <div class="count">
                    <h3>Book-For-Sell</h3>
                    <?php
                    $query = mysqli_query($conn, "select * from book where Book_location= -1") or die(mysqli_error($conn) . "count error");
                    $count = mysqli_num_rows($query);
                    if ($count > 0) {
                        echo "<p>{$count}</p>";
                    } else {
                        echo "<p>0</p>";
                    }
                    ?>
                </div>
                <div class="count">
                    <h3>Order-dilevery</h3>
                    <?php
                    $query = mysqli_query($conn, "select * from buy_order") or die(mysqli_error($conn) . "count error");
                    $count = mysqli_num_rows($query);
                    if ($count > 0) {
                        echo "<p>{$count}</p>";
                    } else {
                        echo "<p>0</p>";
                    }
                    ?>
                </div>
                <div class="count">
                    <h3>Order-Pickup</h3>
                    <?php
                    $query = mysqli_query($conn, "select * from sell_order") or die(mysqli_error($conn) . "count error");
                    $count = mysqli_num_rows($query);
                    if ($count > 0) {
                        echo "<p>{$count}</p>";
                    } else {
                        echo "<p>0</p>";
                    }
                    ?>
                </div>
                <div class="count">
                    <h3>Order-Dilivered</h3>
                    <p>0</p>
                </div>
            </div>
            <div id="graph">
            </div>
        </div>
        <div id="tables"></div>
    </section>
    <div class="view">
        <div class="view-contant">
            <button class="close-button"><i class="fa-solid fa-xmark"></i></button>
            <div class="view-data"></div>
        </div>
    </div>
    <div>
        <p id="success" hidden></p>
    </div>
    <div>
        <p id="error" hidden></p>
    </div>
    <footer>
        <p>All rights reserved by <a href="#">Book-Wala</a></p>
    </footer>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> this is a cdn link of jquery-3.6.0 -->
    <script src="../js/jquery-3.6.0.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>