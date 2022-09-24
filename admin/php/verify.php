<?php
    include "config.php";
    $verify = mysqli_real_escape_string($conn, $_GET['verify']);
    $update = "update admin set status = 1 where verify_OTP = '{$verify}'";
    if(mysqli_query($conn,$update)){
        header("location: $url/admin");
    }else{
        echo "verification code not match any redord";
    }
?>