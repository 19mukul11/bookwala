<?php
    $host = 'localhost';
    $username = 'root';
    $database = 'bookwala';
    $password = '';
    $conn = mysqli_connect($host, $username, $password, $database) or die(mysqli_connect_error()."connection error");

    /*
        folder stuctures
        create a folder bookWala in htdocs folder in xampp install folder

        xampp/htdocs/bookWala/
    */
    //$url = 'http://192.168.43.12/bookwala';
     $url = 'http://localhost/bookwala';
?>