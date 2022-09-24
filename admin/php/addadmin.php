<?php
    include 'config.php';
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $deg = mysqli_real_escape_string($conn, $_POST['deg']);
    $password = mysqli_real_escape_string($conn, sha1($_POST['password']));
    $id="A-".mt_rand();
    $verify=mt_rand();

    $insert = "insert into admin(Admin_id,Admin_first_name,Admin_last_name,Admin_email,Admin_phone,Admin_designation,Admin_password,status,verify_OTP) values('{$id}','{$fname}','{$lname}','{$email}','{$phone}','{$deg}','{$password}',0,'{$verify}')";

    $queary = mysqli_query($conn, $insert) or die(mysqli_error($conn)."admin insertion error");
    if($queary){
        $to = $email;
        $subject = "Verification email from Book-Wala";
        $message = "<a href = 'http://localhost/bookwala/admin/php/verify.php?verify={$verify}'>click to verify</a>";
        $headers = "From: bookwalateam@gmail.com" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        mail($to, $subject, $message, $headers);
        echo 1;
    }else{
        echo 0;
    }
?>