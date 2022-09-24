<?php
include "config.php";
$id = $_POST['id'];
$output = "";
$choice = substr($id, 0, 1);
switch ($choice) {
    case 'A':
        admin();
        break;
    case 'C':
        customer();
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
    $GLOBALS['output'] .= "<h3>View-Admin-Data</h3>
                        <table>
                            <tbody>";
    $select = "select * from admin where Admin_id = '{$GLOBALS['id']}'";
    $query = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "view error");
    $row = mysqli_fetch_assoc($query);
    $GLOBALS['output'] .=   "<tr>
                                    <td>Admin Id :- </td>
                                    <td>{$row['Admin_id']}</td>
                                </tr>
                                <tr>
                                    <td>Admin First Name :- </td>
                                    <td>{$row['Admin_first_name']}</td>
                                </tr>
                                <tr>
                                    <td>Admin Last Name :- </td>
                                    <td>{$row['Admin_last_name']}</td>
                                </tr>
                                <tr>
                                    <td>Admin Email Id :- </td>
                                    <td>{$row['Admin_email']}</td>
                                </tr>
                                <tr>
                                    <td>Admin Phone Number :- </td>
                                    <td>{$row['Admin_phone']}</td>
                                </tr>
                                <tr>
                                    <td>Admin designation	 :- </td>
                                    <td>{$row['Admin_designation']}</td>
                                </tr>";
    if ($row['status']) {
        $GLOBALS['output'] .= "<tr>
                                                            <td>Status :- </td>
                                                            <td>Varified</td>
                                                        </tr>";
    } else {
        $GLOBALS['output'] .= "<tr>
                                                            <td>Status :- </td>
                                                            <td>Not-Verify</td>
                                                        </tr>";
    }
}
function customer()
{
    $GLOBALS['output'] .= "<h3>View-Customer-Data</h3>
                    <table>
                        <tbody>";
    $select = "select * from customer where Customer_id = '{$GLOBALS['id']}'";
    $query = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "view error");
    $row = mysqli_fetch_assoc($query);
    $GLOBALS['output'] .= "<tr>
                    <td>Customer Id :- </td>
                    <td>{$row['Customer_id']}</td>
                </tr>
                <tr>
                    <td>Customer First Name :- </td>
                    <td>{$row['Customer_first_name']}</td>
                </tr>
                <tr>
                    <td>Customer Last Name :- </td>
                    <td>{$row['Customer_last_name']}</td>
                </tr>
                <tr>
                    <td>Customer Email Id :- </td>
                    <td>{$row['Customer_email']}</td>
                </tr>
                <tr>
                    <td>Customer Phone Number :- </td>
                    <td>{$row['Customer_phone']}</td>
                </tr>";
    if ($row['Verification_status']) {
        $GLOBALS['output'] .= "<tr>
                                            <td>Status :- </td>
                                            <td>Varified</td>
                                        </tr>";
    } else {
        $GLOBALS['output'] .= "<tr>
                                            <td>Status :- </td>
                                            <td>Not-Verify</td>
                                        </tr>";
    }
}
function store()
{
    $GLOBALS['output'] .= "<h3>View-Book-Data</h3>
                        <table>
                            <tbody>";
    $select = "select * from book where Book_id = '{$GLOBALS['id']}'";
    $query = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "view error");
    $row = mysqli_fetch_assoc($query);
    $GLOBALS['output'] .= "<tr>
                        <td>Book Id :- </td>
                        <td>{$row['Book_id']}</td>
                    </tr>
                    <tr>
                        <td>Book Title :- </td>
                        <td>{$row['Book_title']}</td>
                    </tr>
                    <tr>
                        <td>Book Author :- </td>
                        <td>{$row['Book_author']}</td>
                    </tr>
                    <tr>
                        <td>Book Description :- </td>
                        <td>{$row['Book_description']}</td>
                    </tr>
                    <tr>
                        <td>Book Publisher :- </td>
                        <td>{$row['Book_publisher']}</td>
                    </tr>
                    <tr>
                        <td>Book Edition :- </td>
                        <td>{$row['Book_edition']}</td>
                    </tr>
                    <tr>
                        <td>Book Total Page :- </td>
                        <td>{$row['Book_pages']}</td>
                    </tr>
                    <tr>
                        <td>Book Category :- </td>
                        <td>{$row['Book_category_1']}</td>
                    </tr>
                    <tr>
                        <td>Book Sub Category :- </td>
                        <td>{$row['Book_category_2']}</td>
                    </tr>
                    <tr>
                        <td>Book Subject Name :- </td>
                        <td>{$row['Book_category_3']}</td>
                    </tr>
                    <tr>
                        <td>Book MRP :- </td>
                        <td>{$row['Book_MRP']}</td>
                    </tr>
                    <tr>
                        <td>Book Cost Price :- </td>
                        <td>{$row['Book_CP']}</td>
                    </tr>
                    <tr>
                        <td>Book Sell Price :- </td>
                        <td>{$row['Book_SP']}</td>
                    </tr>
                    <tr>";
    $select1 = "select * from book_image where Book_id = '{$row['Book_id']}'";
    $queary1 = mysqli_query($GLOBALS['conn'], $select1) or die(mysqli_error($GLOBALS['conn']) . "image error");
    if (mysqli_num_rows($queary1) > 0) {
        $GLOBALS['output'] .= "<td>Book Images :- </td>
                                    <td><table>
                                        <thead>
                                            <th>Front</th>
                                            <th>Back</th>
                                            <th>MRP</th>
                                            <th>Edition</th>
                                        </thead>
                                        <tr>";
        $image = array();
        while ($row1 = mysqli_fetch_assoc($queary1)) {
            if ($row1['Image_type'] == 'f') {
                $GLOBALS['output'] .= "<td><img src='../../upload/{$row['Book_id']}/{$row1['Image_name']}' width = 200px></td>";
            } else if ($row1['Image_type'] == 'b') {
                $GLOBALS['output'] .= "<td><img src='../../upload/{$row['Book_id']}/{$row1['Image_name']}' width = 200px></td>";
            } else if ($row1['Image_type'] == 'm') {
                $GLOBALS['output'] .= "<td><img src='../../upload/{$row['Book_id']}/{$row1['Image_name']}' width = 200px></td>";
            } else if ($row1['Image_type'] == 'e') {
                $GLOBALS['output'] .= "<td><img src='../../upload/{$row['Book_id']}/{$row1['Image_name']}' width = 200px></td>";
            } else {
                $image[] = $row1['Image_name'];
            }
        }
        $GLOBALS['output'] .= "</tr>
                                    <tr>
                                        <th>Indexs</th>
                                    </tr>
                                    <tr>";
        $i = 0;
        while ($i < sizeof($image)) {
            $GLOBALS['output'] .= "<td><img src='../../upload/{$row['Book_id']}/{$image[$i]}' width = 200px></td>";
            $i++;
        }
        $GLOBALS['output'] .= "</tr></table>";
    }
    $GLOBALS['output'] .= "</td></tr>";
}
function order()
{
    $order = substr($GLOBALS['id'], 0, 2);
    $GLOBALS['output'] .= "<h3>View-Order-Data</h3>
                            <table>
                                <tbody>";
    if ($order != "OS") {
        $select = "select * from buy_order where Order_id = '{$GLOBALS['id']}'";
    } else {
        $select = "select * from sell_order where Order_id = '{$GLOBALS['id']}'";
    }
    $query = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "view error");
    $row = mysqli_fetch_assoc($query);
    $GLOBALS['output'] .=   "   <tr>
                                        <td>Order Id :- </td>
                                        <td>{$row['Order_id']}</td>
                                    </tr>
                                    <tr>
                                        <td>Customer Id :- </td>
                                        <td>{$row['Customer_id']}</td>
                                    </tr>";
    if ($order == "OS") {
        $GLOBALS['output'] .=   "   <tr>
                                                <td>Book Id :- </td>
                                                <td>{$row['Book_id']}</td>
                                            </tr>";
    }
    $address = mysqli_query($GLOBALS['conn'], "select * from address where Address_id = '{$row['Address_id']}'");
    $row1 = mysqli_fetch_assoc($address);
    $GLOBALS['output'] .=        "<tr>
                                        <td>Dilevery Address :- </td>
                                        <td>{$row1['Address_line_1']} {$row1['Address_line_2']}, <br>{$row1['Address_tehsil']} , {$row1['Address_district']}<br>{$row1['Address_state']} ,  {$row1['Address_PIN']}</td>
                                    </tr>
                                    <tr>
                                        <td>Date Of Order :- </td>
                                        <td>{$row['Date_time_of_order']}</td>
                                    </tr>
                                    <tr>
                                        <td>Date Of Delivery :- </td>";
    if ($order != "OS") {
        $GLOBALS['output'] .= "<td>{$row['Date_time_of_delivery']}</td>";
    } else {
        $GLOBALS['output'] .= "<td>{$row['Pickup_date_time']}</td>";
    }
    $GLOBALS['output'] .= "
                                    </tr>
                                    ";
    if ($order != "OS") {
        $GLOBALS['output'] .= "<tr>
                                                                        <td>Order Price :- </td>
                                                                        <td>{$row['Order_price']}</td>
                                                                        </tr>";
    }
    $GLOBALS['output'] .= "
                                    <tr>
                                        <td>Excutive Id :- </td>
                                        <td>{$row['Executive_id']}</td>
                                    </tr>";
    if ($row['Status'] == 0) {
        $GLOBALS['output'] .= "<tr>
                                        <td>Order Status :- </td>
                                        <td>Active</td>
                                    </tr>";
    } else {
        $GLOBALS['output'] .= "<tr>
                                        <td>Order Status :- </td>
                                        <td>Completed</td>
                                    </tr>";
    }
}
function excutive()
{
    $GLOBALS['output'] .= "<h3>View-Order-Details</h3>
                            <table>
                                <tbody>";
    $order = substr($GLOBALS['id'], 1, 2);
    $size = strlen($GLOBALS['id']);
    $ide = substr($GLOBALS['id'], 1, $size);
    if ($order == 'OS') {
        $select = "select O.*,B.*,C.* from sell_order as O 
                inner join customer as C 
                on O.Customer_id = C.Customer_id and O.Order_id = '{$ide}'
                inner join book as B 
                on O.Book_id = B.Book_id and O.Order_id = '{$ide}'";

        $select1 = "select C.*,A.*,O.* from sell_order as O 
                inner join address as A 
                on O.Address_id = A.Address_id
                inner join customer as C 
                on O.Customer_id = C.Customer_id and O.Order_id = '{$ide}'";
    } else {
        $select = "select O.*,C.* from buy_order as O 
                inner join customer as C 
                on O.Customer_id = C.Customer_id and O.Order_id = '{$ide}'";

        $select1 = "select C.*,A.*,O.* from buy_order as O 
                inner join address as A 
                on O.Address_id = A.Address_id
                inner join customer as C 
                on O.Customer_id = C.Customer_id and O.Order_id = '{$ide}'";
    }
    $query = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "view error");
    if (mysqli_num_rows($query)) {
        while ($row = mysqli_fetch_assoc($query)) {
            $GLOBALS['output'] .=   "   <tr>
                                            <td>Order Id :- </td>
                                            <td>{$row['Order_id']}</td>
                                        </tr>
                                        <tr>
                                            <td>Customer Name :- </td>
                                            <td>{$row['Customer_first_name']} {$row['Customer_last_name']}</td>
                                        </tr>";
            if ($order == 'OS') {
                $GLOBALS['output'] .= "<tr>
                                            <td>Book Details :- </td>
                                            <td>BT-{$row['Book_title']}<br>BA-{$row['Book_author']}</td>
                                        </tr>
                                        ";
            } else {
                $GLOBALS['output'] .= "<tr>
                                            <td>Amount :- </td>
                                            <td>{$row['Order_price']}</td>
                                        </tr>
                                        ";
            }
            $queary1 = mysqli_query($GLOBALS['conn'], $select1) or die(mysqli_error($GLOBALS['conn']));
            while ($row1 = mysqli_fetch_assoc($queary1)) {
                $GLOBALS['output'] .= "<tr>
                                            <td>Customer Address :- </td>
                                            <td>{$row1['Address_line_1']} {$row1['Address_line_2']},<br>{$row1['Address_tehsil']} , {$row1['Address_district']}<br>{$row1['Address_state']} , {$row1['Address_PIN']}</td>
                                        </tr>";
            }
        }
    }
}
$output .= "</tbody></table>";
echo $output;
