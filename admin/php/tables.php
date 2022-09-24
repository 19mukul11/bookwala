<?php
    include "config.php";
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: $url/admin/php/login.php");
    }
    $id = $_POST['id'];
    $output = "";

    $page = "";
    $limit = 10;
    if(isset($_POST['page'])){
        $page = $_POST['page'];
    }else{
        $page = 1;
    }
    $offset = ($page-1) * $limit;
    $count = $offset + 1;
    switch($id) {
        case "admin" : admin();
            break;
        case "customer" : customer();
            break;
        case "store" : store();
            break;
        case "order" : order();
            break;
        case "payment" : payment();
            break;
        case "excutive" : excutive();
            break;
    }
    function admin() {
        $GLOBALS['output'] .=  "<h1>Admin-Details</h1>
                                <table>";
        $GLOBALS['output'] .=   "<thead>
                                    <th>S.no</th>
                                    <th>Admin Id</th>
                                    <th>Admin Name</th>
                                    <th>Admin Email</th>
                                    <th>Admin phone</th>
                                    <th>verified</th>
                                    <th>View/Edit/Delete</th>
                                </thead>
                                <tbody>";
        $select = "select Admin_id,Admin_first_name,Admin_last_name,Admin_email,Admin_phone,status from Admin limit {$GLOBALS['offset']},{$GLOBALS['limit']}";
        $queary = mysqli_query($GLOBALS['conn'],$select) or die(mysqli_error($GLOBALS['conn'])."Admin table");
        if(mysqli_num_rows($queary)>0){
            while($row = mysqli_fetch_assoc($queary)){
                $GLOBALS['output'] .=  "<tr>
                                            <td>{$GLOBALS['count']}</td>
                                            <td>{$row['Admin_id']}</td>
                                            <td>{$row['Admin_first_name']} {$row['Admin_last_name']}</td>
                                            <td>{$row['Admin_email']}</td>
                                            <td>{$row['Admin_phone']}</td>";
                                            if($row['status']){
                                                $GLOBALS['output'] .= "<td style='background-color:#20B2AA;color:#fff;font-weight:bold'>Verified</td>";
                                            }else{
                                                $GLOBALS['output'] .= "<td style='background-color:#FD1C03;color:#000;font-weight:bold'>Not-Verify</td>";
                                            }
                $GLOBALS['output'] .= "
                                            <td>
                                                <button id='aview' data-aid='{$row['Admin_id']}'><i class='fa-solid fa-eye'></i></button>
                                                <button id='aedit' data-eid='{$row['Admin_id']}'><i class='fa-solid fa-pencil'></i></button>
                                                <button id='adelete' data-did='{$row['Admin_id']}'><i class='fa-solid fa-trash'></i></button>
                                            </td>
                                        </tr>";
                $GLOBALS['count']++;
            }
            $record = mysqli_query($GLOBALS['conn'],"select * from admin") or die(mysqli_error($GLOBALS['conn']));
            $total_record = mysqli_num_rows($record);
            $total_pages = ceil($total_record / $GLOBALS['limit']);
            $GLOBALS['output'] .= "</tbody>
                </table>
                <div id='page-a'>";
            for($i = 1 ; $i <= $total_pages ; $i++){
                if($i == $GLOBALS['page']){
                    $class = "active";
                }else{
                    $class = "";
                }
                $GLOBALS['output'] .= "<a class='{$class}' id='{$i}' href=''>{$i}</a>";
            }
            $GLOBALS['output'] .= "</div>";
        }
    }
    function customer(){
        $GLOBALS['output'] .=  "<h1>Customer-Details</h1>
                    <table>";
        $GLOBALS['output'] .=   "<thead>
                            <th>S.no</th>
                            <th>Customer Id</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Customer phone</th>
                            <th>Status</th>
                            <th>View/Edit/Delete</th>
                        </thead>
                        <tbody>";
        $select = "select Customer_id,Customer_first_name,Customer_last_name,Customer_email,Customer_phone,Verification_status from customer limit {$GLOBALS['offset']},{$GLOBALS['limit']}";
        $query = mysqli_query($GLOBALS['conn'],$select) or die(mysqli_error($GLOBALS['conn'])."customer table not lode");
        if(mysqlI_num_rows($query)>0){
            while($row = mysqli_fetch_assoc($query)){
                $GLOBALS['output'] .=  "<tr>
                                    <td>{$GLOBALS['count']}</td>
                                    <td>{$row['Customer_id']}</td>
                                    <td>{$row['Customer_first_name']} {$row['Customer_last_name']}</td>
                                    <td>{$row['Customer_email']}</td>
                                    <td>{$row['Customer_phone']}</td>";
                                    if($row['Verification_status']){
                                        $GLOBALS['output'] .= "<td style='background-color:#20B2AA;color:#fff;font-weight:bold'>Verified</td>";
                                    }else{
                                        $GLOBALS['output'] .= "<td style='background-color:#FD1C03;color:#000;font-weight:bold'>Not-Verify</td>";
                                    }
                $GLOBALS['output'] .= "
                                    <td>
                                        <button id='cview' data-cid='{$row['Customer_id']}'><i class='fa-solid fa-eye'></i></button>   
                                        <button id='cdelete' data-did='{$row['Customer_id']}'><i class='fa-solid fa-trash'></i></button>
                                    </td>
                                </tr>";
                $GLOBALS['count']++;
            }
            $record = mysqli_query($GLOBALS['conn'], "select * from customer") or die(mysqli_error($GLOBALS['conn']));
            $total_record = mysqli_num_rows($record);
            $total_pages = ceil($total_record / $GLOBALS['limit']);
            $GLOBALS['output'] .= "</tbody>
                        </table>
                        <div id='page-c'>";
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $GLOBALS['page']) {
                    $class = "active";
                } else {
                    $class = "";
                }
                $GLOBALS['output'] .= "<a class='{$class}' id='{$i}' href=''>{$i}</a>";
            }
            $GLOBALS['output'] .= "</div>";
        }
    }
    function store(){
        $book = $_POST['book'];
        $GLOBALS['output'] .=   "<h1>Book-Details</h1>
                                <table>";
        $GLOBALS['output'] .=   "<thead>
                                    <th>S.no</th>
                                    <th>Book Id</th>
                                    <th>Book Title</th>
                                    <th>Book Author</th>
                                    <th>Book Publisher</th>
                                    <th>Book Status</th>
                                    <th>View/Edit/Delete</th>
                                </thead>
                                <tbody>";
        if($book == 0){
            $select = "select Book_id,Book_title,Book_author,Book_publisher,Book_status from book where Book_location = {$book} limit {$GLOBALS['offset']},{$GLOBALS['limit']}";
        }else if($book == 1){
            $select = "select Book_id,Book_title,Book_author,Book_publisher,Book_status from book where Book_location = {$book}  limit {$GLOBALS['offset']},{$GLOBALS['limit']}";
        }
        $queary = mysqli_query($GLOBALS['conn'],$select) or die(mysqli_error($GLOBALS['conn'])."book table status");
        if(mysqli_num_rows($queary) > 0){
            while($row = mysqli_fetch_assoc($queary)){
                $GLOBALS['output'] .=  "<tr>
                                        <td>{$GLOBALS['count']}</td>
                                        <td>{$row['Book_id']}</td>
                                        <td>{$row['Book_title']}</td>
                                        <td>{$row['Book_author']}</td>
                                        <td>{$row['Book_publisher']}</td>";
                                        if($row['Book_status'] == 0){
                                            $GLOBALS['output'] .= "<td style='background-color:#50C878;color:#000;font-weight:bold;'>Verified</td>";
                                        }else if($row['Book_status'] == -1){
                                            $GLOBALS['output'] .= "<td style='background-color:#FF0000;color:#000;font-weight:bold;'>Not-Verified</td>";
                                        }else if($row['Book_status'] == 1){
                                            $GLOBALS['output'] .= "<td style='background-color:#6698FF;color:#000;font-weight:bold;'>Verified</td>";
                                        }else{
                                            $GLOBALS['output'] .= "<td style='background-color:#228B22;color:#000;font-weight:bold;'>Booked</td>";
                                        }
                $GLOBALS['output'] .= "<td>
                                            <button id='bview' data-bid='{$row['Book_id']}'><i class='fa-solid fa-eye'></i></button>";
                                            if($row['Book_status'] != -1 || $row['Book_status'] != 2){
                                                $GLOBALS['output'] .= "<button id='bedit' data-eid='{$row['Book_id']}'><i class='fa-solid fa-pencil'></i></button>";
                                            }
                $GLOBALS['output'] .= "
                                            <button id='bdelete' data-did='{$row['Book_id']}'><i class='fa-solid fa-trash'></i></button>
                                        </td>
                                    </tr>";
                $GLOBALS['count']++;
            }
            $record = mysqli_query($GLOBALS['conn'], "select * from book") or die(mysqli_error($GLOBALS['conn']));
            $total_record = mysqli_num_rows($record);
            $total_pages = ceil($total_record / $GLOBALS['limit']);
            $GLOBALS['output'] .= "</tbody>
                        </table>
                        <div id='page-b'>";
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $GLOBALS['page']) {
                    $class = "active";
                } else {
                    $class = "";
                }
                $GLOBALS['output'] .= "<a class='{$class}' id='{$i}' href=''>{$i}</a>";
            }
            $GLOBALS['output'] .= "</div>";
        }
    }
    function order(){
        $order = $_POST['order'];
        $GLOBALS['output'] .=   "<h1>Order-Details</h1>
                                <table>";
        $GLOBALS['output'] .=   "<thead>
                                    <th>S.no</th>
                                    <th>Order Id</th>
                                    <th>Customer Id</th>
                                    <th>Date Of Order</th>
                                    <th>Date Of Deliver</th>";
                                    if ($order == 1) {
                                        $GLOBALS['output'] .= "<th>Price</th>";
                                    }
        $GLOBALS['output'] .= "
                                    <th>Status</th>
                                    <th>View/Edit/Delete</th>
                                </thead>
                                <tbody>";
        if($order == 1) {
            $select = "select Order_id,Customer_id,Date_time_of_order,Date_time_of_delivery,Order_price,status from buy_order limit {$GLOBALS['offset']},{$GLOBALS['limit']}";
            $select1 = "select * from buy_order";
        }else{
            $select = "select Order_id,Customer_id,Date_time_of_order,Pickup_date_time,status from sell_order limit {$GLOBALS['offset']},{$GLOBALS['limit']}";
            $select1 = "select * from sell_order";
        }
        $queary = mysqli_query($GLOBALS['conn'],$select) or die(mysqli_error($GLOBALS['conn'])."order error");
        if(mysqli_num_rows($queary)>0){
            while($row = mysqli_fetch_assoc($queary)){
                $GLOBALS['output'] .=  "<tr>
                                        <td>{$GLOBALS['count']}</td>
                                        <td>{$row['Order_id']}</td>
                                        <td>{$row['Customer_id']}</td>
                                        <td>{$row['Date_time_of_order']}</td>";
                                        if($order != 1){
                                            $GLOBALS['output'] .="<td>{$row['Pickup_date_time']}</td>";
                                        }else{
                                            $GLOBALS['output'] .= "<td>{$row['Date_time_of_delivery']}</td>";
                                        }
                                        if($order == 1){
                                            $GLOBALS['output'] .= "<td>{$row['Order_price']}</td>";
                                        }
                                        if($row['status']==0){
                                            $GLOBALS['output'] .= "<td style='background-color:#00BFFF;color:#000;font-weight:bold;'>Active</td>";
                                        }else{
                                            $GLOBALS['output'] .= "<td style='background-color:#3EB489;color:#fff;font-weight:bold;'>Complete</td>";
                                        }
                $GLOBALS['output'] .= "
                                        <td>
                                            <button id='oview' data-vid='{$row['Order_id']}'><i class='fa-solid fa-eye'></i></button>";
                                            if($row['status']!=2){
                                                $GLOBALS['output'] .="<button id='oedit' data-eid='{$row['Order_id']}'><i class='fa-solid fa-pencil'></i></button>";
                                            }
                $GLOBALS['output'] .= "<button id='odelete' data-did='{$row['Order_id']}'><i class='fa-solid fa-trash'></i></button>
                                        </td>
                                    </tr>";

                                    $GLOBALS['count']++;
            }


            $record = mysqli_query($GLOBALS['conn'], $select1) or die(mysqli_error($GLOBALS['conn']));
            $total_record = mysqli_num_rows($record);
            $total_pages = ceil($total_record / $GLOBALS['limit']);
            $GLOBALS['output'] .= "</tbody>
                            </table>
                            <div id='page-o'>";
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $GLOBALS['page']) {
                    $class = "active";
                } else {
                    $class = "";
                }
                $GLOBALS['output'] .= "<a class='{$class}' id='{$i}' href=''>{$i}</a>";
            }
            $GLOBALS['output'] .= "</div>";
        }
    }
    function payment(){
        $payment = $_POST['payment'];
        if ($payment == 1) {
            $select = "select * from payment_buy";
            $GLOBALS['output'] .=   "<h1>Payment-Details-Buy-Order</h1>
                                <table>";
        } else {
            $select = "select * from payment_sell";
            $GLOBALS['output'] .=   "<h1>Payment-Details-Sell-Order</h1>
                                <table>";
        }
        $GLOBALS['output'] .=   "<thead>
                                    <th>S.no</th>
                                    <th>Payment Id</th>
                                    <th>Order Id</th>
                                    <th>Customer Id</th>
                                    <th>Amount</th>
                                    <th>Date Of Payment</th>
                                    <th>Excutive Id</th>
                                    <th>View/Edit/Delete</th>
                                </thead>
                                <tbody>";
        $queary = mysqli_query($GLOBALS['conn'],$select) or die(mysqli_error($GLOBALS['conn'])."payment error");
        if(mysqli_num_rows($queary)>0){
            while ($row = mysqli_fetch_assoc($queary)) {
            $GLOBALS['output'] .=  "<tr>
                                    <td>{$GLOBALS['count']}</td>
                                    <td>{$row['Payment_id']}</td>
                                    <td>{$row['Order_id']}</td>
                                    <td>{$row['Customer_id']}</td>
                                    <td>{$row['Amount']}</td>
                                    <td>{$row['Date_time_of_payment']}</td>
                                    <td>{$row['Executive_id']}</td>
                                    <td>
                                        <button><i class='fa-solid fa-trash'></i></button>
                                    </td>
                                </tr>";
                    $GLOBALS['count']++;
            }
            $record = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']));
            $total_record = mysqli_num_rows($record);
            $total_pages = ceil($total_record / $GLOBALS['limit']);
            $GLOBALS['output'] .= "</tbody>
                                </table>
                                <div id='page-o'>";
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $GLOBALS['page']) {
                    $class = "active";
                } else {
                    $class = "";
                }
                $GLOBALS['output'] .= "<a class='{$class}' id='{$i}' href=''>{$i}</a>";
            }
            $GLOBALS['output'] .= "</div>";
        }
    }
    function excutive() {
        if ($_SESSION['designation'] == 'pickup executive') {
            $select = "select * from sell_order where status = 0 limit {$GLOBALS['offset']},{$GLOBALS['limit']}";
            $GLOBALS['output'] .=  "<h1>Pickup-Details</h1>
                                    <table>";
        } else {
            $select = "select * from buy_order where status = 0 limit {$GLOBALS['offset']},{$GLOBALS['limit']}";
            $GLOBALS['output'] .=  "<h1>Dilivery-Details</h1>
                                    <table>";
        }
        $GLOBALS['output'] .=   "<thead>
                                        <th>S.no</th>
                                        <th>Order id</th>
                                        <th>Details of Customer</th>
                                        <th>buttons</th>
                                    </thead>
                                    <tbody>";
        $queary = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "Admin table");
        if (mysqli_num_rows($queary) > 0) {
            while ($row = mysqli_fetch_assoc($queary)) {
                if($row['Status'] == 0){
                    $query1 = mysqli_query($GLOBALS['conn'], "select * from customer where Customer_id = '{$row['Customer_id']}'") or die(mysqli_error($GLOBALS['conn']));
                    $row1 = mysqli_fetch_assoc($query1);
                    $query2 = mysqli_query($GLOBALS['conn'], "select * from address where Address_id = '{$row['Address_id']}'") or die(mysqli_error($GLOBALS['conn']));
                    $row2 = mysqli_fetch_assoc($query2);
                    $GLOBALS['output'] .=  "<tr>
                                                <td>{$GLOBALS['count']}</td>
                                                <td>{$row['Order_id']}</td>";
                        $GLOBALS['output'] .= "<td><b>Name</b> :- {$row1['Customer_first_name']} {$row1['Customer_last_name']}<br><b>Phone</b> :- {$row1['Customer_phone']}<br><b>Address</b> :- {$row2['Address_line_1']} {$row2['Address_line_2']}<br>{$row2['Address_tehsil']},{$row2['Address_district']},{$row2['Address_PIN']}</td>";
                    $GLOBALS['output'] .= "
                                                <td>
                                                    <button id='eview' data-vxid='{$row['Order_id']}'><i class='fa-solid fa-eye'></i></button>
                                                    <button id='eedit' data-exid='{$row['Order_id']}'><i class='fa-solid fa-check'></i></button>";
                                                    if(substr($row['Order_id'],0,2) == 'OS'){
                                                        $GLOBALS['output'] .= "<button id='edelete' data-dxid='{$row['Order_id']}'><i class='fa-solid fa-xmark'></i></button>";
                                                    }
                $GLOBALS['output'] .= "</td>
                                            </tr>";
                }
                $GLOBALS['count']++;
            }
    }
    $GLOBALS['output'] .= "</tbody>
                </table>";
    }
    echo $output;
?>