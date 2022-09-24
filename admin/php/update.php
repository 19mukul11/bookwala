<?php
include "config.php";
$id = $_POST['id'];
$choice = substr($id, 0, 1);
switch ($choice) {
    case 'A':
        admin();
        break;
    case 'B':
        store();
        break;
    case 'O':
        order();
        break;
    case 'E':
        excutive();
        break;
}
function admin()
{
    $afname = mysqli_real_escape_string($GLOBALS['conn'], $_POST['afname']);
    $alname = mysqli_real_escape_string($GLOBALS['conn'], $_POST['alname']);
    $aemail = mysqli_real_escape_string($GLOBALS['conn'], $_POST['aemail']);
    $aphone = mysqli_real_escape_string($GLOBALS['conn'], $_POST['aphone']);
    $adeg = mysqli_real_escape_string($GLOBALS['conn'], $_POST['adeg']);

    $update = "update admin set Admin_first_name = '{$afname}',Admin_last_name = '{$alname}',Admin_email = '{$aemail}',Admin_phone = '{$aphone}',Admin_designation = '{$adeg}' where Admin_id = '{$GLOBALS['id']}'";

    mysqli_query($GLOBALS['conn'], $update) or die(mysqli_error($GLOBALS['conn']) . "update error");
}
function store()
{
    $select = "select Book_location from book where Book_id = '{$GLOBALS['id']}'";
    $queary = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']));
    $row = mysqli_fetch_assoc($queary);
    $blocation = mysqli_real_escape_string($GLOBALS['conn'], $_POST['blocation']);
    if(isset($_POST['btitle'])){
        $btitle = mysqli_real_escape_string($GLOBALS['conn'], $_POST['btitle']);
        $bauthor = mysqli_real_escape_string($GLOBALS['conn'], $_POST['bauthor']);
        $bdesc = mysqli_real_escape_string($GLOBALS['conn'], $_POST['bdesc']);
        $bpublisher = mysqli_real_escape_string($GLOBALS['conn'], $_POST['bpublisher']);
        $bedition = mysqli_real_escape_string($GLOBALS['conn'], $_POST['bedition']);
        $bpage = mysqli_real_escape_string($GLOBALS['conn'], $_POST['bpage']);
        $category = mysqli_real_escape_string($GLOBALS['conn'], $_POST['category']);
        $subcategory = mysqli_real_escape_string($GLOBALS['conn'], $_POST['subcategory']);
        $subbook = mysqli_real_escape_string($GLOBALS['conn'], $_POST['subBook']);
        $bmrp = mysqli_real_escape_string($GLOBALS['conn'], $_POST['bmrp']);
        $bcost = mysqli_real_escape_string($GLOBALS['conn'], $_POST['bcost']);
        $bsell = mysqli_real_escape_string($GLOBALS['conn'], $_POST['bsell']);
        $bstatus = mysqli_real_escape_string($GLOBALS['conn'],$_POST['bstatus']);

        $select2 = "update book set Book_title = '{$btitle}', Book_author = '{$bauthor}', Book_description = '{$bdesc}', Book_publisher = '{$bpublisher}', Book_edition = {$bedition}, Book_pages = {$bpage}, Book_category_1 = '{$category}',Book_category_2 = '{$subcategory}', Book_category_3 = '{$subbook}', Book_MRP = {$bmrp}, Book_CP = {$bcost}, Book_SP = {$bsell}, Book_location = {$blocation}, Book_status = {$bstatus} where Book_id = '{$GLOBALS['id']}'";
    }else{
        $select2 = "update book set Book_location = {$blocation} where Book_id = '{$GLOBALS['id']}'";
    }
    mysqli_query($GLOBALS['conn'], $select2) or die(mysqli_error($GLOBALS['conn']));
    echo $row['Book_location'];
}
function order()
{
    $dodelivery =  mysqli_real_escape_string($GLOBALS['conn'], $_POST['dodelivery']);
    $address1 =  mysqli_real_escape_string($GLOBALS['conn'], $_POST['address1']);
    $address2 = mysqli_real_escape_string($GLOBALS['conn'], $_POST['address2']);
    $addresspin =  mysqli_real_escape_string($GLOBALS['conn'], $_POST['addresspin']);
    $addresscity =  mysqli_real_escape_string($GLOBALS['conn'], $_POST['addresscity']);
    $addressdistrict = mysqli_real_escape_string($GLOBALS['conn'],$_POST['addressdistrict']);
    $exdeg = mysqli_real_escape_string($GLOBALS['conn'], $_POST['exdeg']);
    $addressstate =  mysqli_real_escape_string($GLOBALS['conn'], $_POST['addressstate']);
    $order = substr($GLOBALS['id'],0,2);
    $row = array();
    $status = 0;
    if($order == 'OS'){
        mysqli_query($GLOBALS['conn'], "update sell_order set Pickup_date_time = '{$dodelivery}', Executive_id = '{$exdeg}' where Order_id = '{$GLOBALS['id']}'") or die(mysqli_error($GLOBALS['conn']) . 'update error');

        $row = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"select Address_id from sell_order where Order_id = '{$GLOBALS['id']}'"));

    }else{
        mysqli_query($GLOBALS['conn'], "update buy_order set Date_time_of_delivery = '{$dodelivery}',Executive_id = '{$exdeg}' where Order_id = '{$GLOBALS['id']}'") or die(mysqli_error($GLOBALS['conn']) . 'update error');

        $row = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "select Address_id from buy_order where Order_id = '{$GLOBALS['id']}'"));
        $status = 1;
    }

    mysqli_query($GLOBALS['conn'], "update address set Address_line_1 = '{$address1}',Address_line_2 = '{$address2}',Address_PIN = '{$addresspin}',	Address_tehsil = '{$addresscity}',Address_district = '{$addressdistrict}',Address_state = '{$addressstate}' where Address_id = '{$row['Address_id']}'");

    echo $status;
}
function excutive(){
    $ide = substr($GLOBALS['id'],1,strlen($GLOBALS['id']));
    $order = substr($GLOBALS['id'],1,2);
    $amount = mysqli_real_escape_string($GLOBALS['conn'], $_POST['amount']);
    $otp = mysqli_real_escape_string($GLOBALS['conn'], $_POST['otp']);
    date_default_timezone_set("Asia/Kolkata");
    $date = date("Y-m-d H:i:s");
    $pid = "P-" . mt_rand();
    if($order == "OS"){
        $select = mysqli_query($GLOBALS['conn'], "select * from sell_order where Order_id = '{$ide}'") or die(mysqli_error($GLOBALS['conn']));
        $row = mysqli_fetch_assoc($select);
        if($row['OTP'] == $otp && $row['Executive_id']){
            if (mysqli_query($GLOBALS['conn'], "update sell_order set status = 2, Pickup_date_time = '{$date}' where Order_id = '{$ide}'") && mysqli_query($GLOBALS['conn'], "update book set Book_CP = '{$amount}',Book_status = 0 where Book_id = '{$row['Book_id']}'") && mysqli_query($GLOBALS['conn'], "insert into payment_sell(Payment_id,Customer_id,Order_id,Amount,Date_time_of_payment,Executive_id) values('{$pid}','{$row['Customer_id']}','{$ide}','{$amount}','{$date}','{$row['Executive_id']}')")) {
                $row1 = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"select Customer_email,Customer_phone,Customer_first_name,Customer_last_name from customer where Customer_id = '{$row['Customer_id']}'"));
                $to = $row1['Customer_email'];
                $subject = "Payment from Bookwala";
                $message = "<html>
                            <head>
                                <style>
                                    table tr td, table tr th{
                                        border:1px solid grey;
                                        text-align:center;
                                    }
                                </style>
                            </head>
                            <body>
                                <img src='https://i.ibb.co/mR7kc8J/logo.jpg' alt='logo' border='0'>
                                <h3>Hii {$row1['Customer_first_name']} {$row1['Customer_last_name']},</h3>
                                <p> Thankyou for shopping with us. Your order has been successfully delivered on {$date}. Please find out the order summary below.
                                </p>
                                <br>
                                <b>Delivery Address : </b> <br>{$row1['Customer_first_name']} {$row1['Customer_last_name']}<br>
                                ";
                $row2 = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "select * from address where Address_id = '{$row['Address_id']}'"));

                $message .= "{$row2['Address_line_1']} {$row2['Address_line_2']}<br>{$row2['Address_tehsil']} , {$row2['Address_district']}<br>{$row2['Address_PIN']}<br>
                                {$row1['Customer_phone']}, {$row1['Customer_email']}
                                <br>
                                <br>
                                <h4>Order ID : {$ide}</h4>
                                <h4>Order Placed on : {$row['Date_time_of_order']}</h4>
                                <br>
                                    <h4>Mode of payment : Cash on Pickup</h4>
                                    <h3>Total Amount  recieved by customer : &#8377; {$amount}</h3>
                                <br><br>
                                Thankyou
                            </body>
                        </html>";
                $headers = "From: bookwalateam@gmail.com" . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                mail($to,
                    $subject,
                    $message,
                    $headers
                );
                echo 1;
            } else {
                echo mysqli_error($GLOBALS['conn']);
            }
        }else{
            echo "<script>alert('OTP or Amount not match')</script>";
        }
    }else{
        $select = mysqli_query($GLOBALS['conn'], "select * from buy_order where Order_id = '{$ide}'") or die(mysqli_error($GLOBALS['conn']));
        $row = mysqli_fetch_assoc($select);

        if($row['Order_price'] == $amount && $row['otp'] == $otp){
            $queary_select = mysqli_query($GLOBALS['conn'], "select * from sold_book where Order_id = '{$ide}'") or die(mysqli_error($GLOBALS['conn']));
            if(mysqli_num_rows($queary_select)>0){
                $row1 = mysqli_fetch_assoc($queary_select);
                $queary1 = mysqli_query($GLOBALS['conn'], "update book set Book_status = 2 where Book_id = '{$row1['Book_id']}'");
            }else{
                $queary1=0;
            }
            if (mysqli_query($GLOBALS['conn'], "update buy_order set status = 2 where Order_id = '{$ide}'") && $queary1 && mysqli_query($GLOBALS['conn'], "insert into payment_buy(Payment_id,Customer_id,Order_id,Amount,Date_time_of_payment,	Executive_id) values('{$pid}','{$row['Customer_id']}','{$ide}','{$amount}','{$date}','{$row['Executive_id']}')")) {
                $row1 = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "select Customer_email,Customer_phone,Customer_first_name,Customer_last_name from customer where Customer_id = '{$row['Customer_id']}'"));
                $to = $row1['Customer_email'];
                $subject = "Payment from Bookwala";
                $message = "<html>
                            <head>
                                <style>
                                    table tr td, table tr th{
                                        border:1px solid grey;
                                        text-align:center;
                                    }
                                </style>
                            </head>
                            <body>
                                <img src='https://i.ibb.co/mR7kc8J/logo.jpg' alt='logo' border='0'>
                                <h3>Hii {$row1['Customer_first_name']} {$row1['Customer_last_name']},</h3>
                                <p> Thankyou for shopping with us. Your order has been successfully delivered on {$date}. Please find out the order summary below.
                                </p>
                                <br>
                                <b>Delivery Address : </b> <br>{$row1['Customer_first_name']} {$row1['Customer_last_name']}<br>
                                ";
                                $row2 = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "select * from address where Address_id = '{$row['Address_id']}'"));

                $message .= "{$row2['Address_line_1']} {$row2['Address_line_2']}<br>{$row2['Address_tehsil']} , {$row2['Address_district']}<br>{$row2['Address_PIN']}<br>
                                {$row1['Customer_phone']}, {$row1['Customer_email']}
                                <br>
                                <br>
                                <h4>Order ID : {$ide}</h4>
                                <h4>Order Placed on : {$row['Date_time_of_order']}</h4>
                                <br>
                                    <h4>Mode of payment : Cash on Pickup</h4>
                                    <h3>Total Amount  recieved by customer : &#8377; {$amount}</h3>
                                <br><br>
                                Thankyou
                            </body>
                        </html>";
                $headers = "From: bookwalateam@gmail.com" . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                mail(
                    $to,
                    $subject,
                    $message,
                    $headers
                );
                echo 1;
            } else {
                echo 0;
            }
        }else{
            echo "<script>alert('Amount enter is mot match with price')</script>";
        }
    }
}
?>