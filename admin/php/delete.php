<?php
    include "config.php";
    $id = $_POST['id'];
    $choice = substr($id, 0, 1);
    switch ($choice) {
        case 'A' : admin();
            break;
        case 'C' : customer ();
            break;
        case 'B' : store();
            break;
        case 'O' : order();
            break;
        case 'E' : excutive();
            break;
    }
    function admin() {
        $delete = "delete from admin where Admin_id = '{$GLOBALS['id']}'";
        mysqli_query($GLOBALS['conn'], $delete) or die(mysqli_error($GLOBALS['conn']) . "delete error");
    }
    function customer () {
        $delete = "delete from customer where Customer_id = '{$GLOBALS['id']}'";
        mysqli_query($GLOBALS['conn'],$delete) or die(mysqli_error($GLOBALS['conn'])."delete error");
    }

    function store(){
        $select = "select * from book_image where Book_id = '{$GLOBALS['id']}'";
        $query = mysqli_query($GLOBALS['conn'],$select) or die(mysqli_error($GLOBALS['conn'])."store error");
        $row = mysqli_fetch_assoc($query);
        if($row['Image_type'] == 'f'){
            unlink("../../upload/" . $row['Book_id'] . "/" . $row['Image_name']);
        }else if($row['Image_type'] == 'b'){
            unlink("../../upload/" . $row['Book_id'] . "/" . $row['Image_name']);
        }else if($row['Image_type'] == 'm'){
            unlink("../../upload/" . $row['Book_id'] . "/" . $row['Image_name']);
        }else if($row['Image_type'] == 'f'){
            unlink("../../upload/" . $row['Book_id'] . "/" . $row['Image_name']);
        }
        while($row1 = mysqli_fetch_assoc($query)){
            if($row['Image_type'] == 'i'){
                unlink("../../upload/" . $row1['Book_id'] . "/" . $row1['Image_name']);
            }
        }
        rmdir("../../upload/".$row['Book_id']);
        mysqli_query($GLOBALS['conn'],"delete from book where Book_id = '{$GLOBALS['id']}'") or die(mysqli_error($GLOBALS['conn']));
    }
    /*function store(){
        $select = "select * from book_image where book_id = '{$GLOBALS['id']}'";
        $query = mysqli_query($GLOBALS['conn'],$select) or die(mysqli_error($GLOBALS['conn'])."store error");
        $row = mysqli_fetch_assoc($query);
        $row1 = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"select * from book_image where folder_name = '{$row['book_image']}'"));
        unlink("../../upload/".$row['Image_name']."/".$row1['image_front']);
        unlink("../../upload/".$row['book_image']."/".$row1['image_back']);
        unlink("../../upload/".$row['book_image']."/".$row1['image_mrp']);
        unlink("../../upload/".$row['book_image']."/".$row1['image_edition']);
        unlink("../../upload/".$row['book_image']."/".$row1['image_middle']);
        rmdir("../../upload/".$row['book_image']);
        mysqli_query($GLOBALS['conn'], "delete from book_image where Book_id = '{$row['Book_id']}'") or die(mysqli_error($GLOBALS['conn']));
        mysqli_query($GLOBALS['conn'],"delete from book where Book_id = '{$GLOBALS['id']}'") or die(mysqli_error($GLOBALS['conn']));
    }*/
    function order() {
        mysqli_query($GLOBALS['conn'],"delete from order_manage where order_id = '{$GLOBALS['id']}'") or die(mysqli_error($GLOBALS['conn'])."delete order error");
    }
    function excutive(){
        $ide = substr($GLOBALS['id'],1,strlen($GLOBALS['id'])-1);
        $order = substr($GLOBALS['id'],1,2);
        if($order == 'OS'){
            mysqli_query($GLOBALS['conn'], "delete from sell_order where Order_id = '{$ide}'") or die(mysqli_error($GLOBALS['conn']));
        }else{
            mysqli_query($GLOBALS['conn'], "delete from buy_order where Order_id = '{$ide}'") or die(mysqli_error($GLOBALS['conn']));
        }
    }
?>