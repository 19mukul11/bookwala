<?php
    include "config.php";
    $id = $_POST['id'];
    $output = "";
    $choice = substr($id, 0, 1);
    switch ($choice) {
        case 'A' : admin();
            break;
        case 'B' : store();
            break;
        case 'O' : order();
            break;
        case 'E' : Excutive();
            break;
    }
    function admin(){
        $GLOBALS['output'] .= "<h3>Edit-Admin-Data</h3>";
        $select = "select * from admin where Admin_id = '{$GLOBALS['id']}'";
        $query = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "edit error");
        $row = mysqli_fetch_assoc($query);
        $GLOBALS['output'] .= "<form>
                                                <table><tbody>
                                                    <tr hidden>
                                                        <td><input type='text' id='aid' value='{$row['Admin_id']}'></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Admin First Name :- </td>
                                                        <td><input type='text' id='afname' value='{$row['Admin_first_name']}'></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Admin last Name :- </td>
                                                        <td><input type='text' id='alname' value='{$row['Admin_last_name']}'></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Admin Email Id :- </td>
                                                        <td><input type='email' id='aemail' value='{$row['Admin_email']}'></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Admin Phone Number :- </td>
                                                        <td><input type='phone' id='aphone' value='{$row['Admin_phone']}'></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Admin Desigination :- </td>
                                                    <td>
                                                    <select id='adeg'>";
        $queary1 = mysqli_query($GLOBALS['conn'], "select * from designation") or die(mysqli_error($GLOBALS['conn']));
        if(mysqli_num_rows($queary1)){
            while($row1 = mysqli_fetch_array($queary1))
                if($row['Admin_designation']==$row1['Dign_name']){
                    $GLOBALS['output'] .= "<option values='{$row1['Dign_name']}' selected>{$row1['Dign_name']}<option>";
                }else{
                    $GLOBALS['output'] .= "<option values='{$row1['Dign_name']}'>{$row1['Dign_name']}<option>";
                }
        }
                                                    
                $GLOBALS['output'] .= "</td>
                                                    </tr>
                                                </tbody></table>
                                                <div><button id='asubmit'>Update</button></div>
                                            </form>";
    }
    function store() {
        $GLOBALS['output'] .= "<h3>Edit-Book-Data</h3>
                        <form id='update-book'>
                            <table>
                                <tbody>";
        $select = "select * from book where Book_id = '{$GLOBALS['id']}'";
        $query = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "view error");
        $row = mysqli_fetch_assoc($query);
        $GLOBALS['output'] .= "<tr hidden>
                                    <td><input type='text' name='id' value='{$row['Book_id']}'></td>
                                </tr>";
        if($row['Book_location'] == 0){
        $GLOBALS['output'] .= "
                                <tr>
                                    <td>Book Title :- </td>
                                    <td><input type='text' name='btitle' value='{$row['Book_title']}' required></td>
                                </tr>
                                <tr>
                                    <td>Book Author :- </td>
                                    <td><input type='text' name='bauthor' value='{$row['Book_author']}' required></td>
                                </tr>
                                <tr>
                                    <td>Book Description :- </td>
                                    <td><textarea type='text' name='bdesc' required>{$row['Book_description']}</textarea></td>
                                </tr>
                                <tr>
                                    <td>Book Publisher :- </td>
                                    <td><input type='text' name='bpublisher' value='{$row['Book_publisher']}' required></td>
                                </tr>
                                <tr>
                                    <td>Book Edition :- </td>
                                    <td><input type='number' name='bedition' value='{$row['Book_edition']}' required></td>
                                </tr>
                                <tr>
                                    <td>Book Total Page :- </td>
                                    <td><input type='number' name='bpage' value='{$row['Book_pages']}' required></td>
                                </tr>
                                <tr>
                                    <td>Book Category :- </td>
                                    <td><select name='category' required></>";
        $select = "select * from category_1";
        $queary = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "category error");
        if (mysqli_num_rows($queary) > 0) {
            while ($row1 = mysqli_fetch_assoc($queary)) {
                if ($row['Book_category_1'] == $row1['Category_id'])
                    $GLOBALS['output'] .= "<option value='{$row1['Category_id']}' selected>{$row1['Category_name_1']}</option>";
                else
                    $GLOBALS['output'] .= "<option value='{$row1['Category_id']}'>{$row1['Category_name_1']}</option>";
            }
        }
        $GLOBALS['output'] .= "</select></td>
                                        </tr>
                                        <tr>
                                            <td>Book Sub Category :- </td>
                                            <td><select name='subcategory' required>";
        $select = "select * from category_2";
        $queary = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "subcategory error");
        if (mysqli_num_rows($queary) > 0) {
            while ($row1 = mysqli_fetch_assoc($queary)) {
                if ($row['Book_category_2'] == $row1['Category_id'])
                $GLOBALS['output'] .= "<option value='{$row1['Category_id']}' selected>{$row1['Category_name_2']}</option>";
                else
                    $GLOBALS['output'] .= "<option value='{$row1['Category_id']}'>{$row1['Category_name_2']}</option>";
            }
        }
        $GLOBALS['output'] .= "</select></td>
                                </tr>
                                <tr>
                                    <td>Book Subject Name :- </td>
                                    <td><select name='subBook' required>";
        $select = "select * from category_3";
        $queary = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "category error");
        if (mysqli_num_rows($queary) > 0) {
            while ($row1 = mysqli_fetch_assoc($queary)) {
                if ($row['Book_category_3'] == $row1['Category_id'])
                $GLOBALS['output'] .= "<option value='{$row1['Category_id']}' selected>{$row1['Category_name_3']}</option>";
                else
                    $GLOBALS['output'] .= "<option value='{$row1['Category_id']}'>{$row1['Category_name_3']}</option>";
            }
        }
        $GLOBALS['output'] .= "</select></td>
                                </tr>
                                <tr>
                                    <td>Book MRP :- </td>
                                    <td><input type='number' name='bmrp' value='{$row['Book_MRP']}' required></td>
                                </tr>
                                <tr>
                                    <td>Book Cost Price :- </td>
                                    <td><input type='number' name='bcost' value='{$row['Book_CP']}' required></td>
                                </tr>
                                <tr>
                                    <td>Book Sell Price :- </td>
                                    <td><input type='number' name='bsell' value='{$row['Book_SP']}' required></td>
                                </tr>
                                <tr>
                                    <td>Book location :- </td>
                                    <td>
                                        <select name='blocation' required>
                                            <option value='0'>Inventory</option>
                                            <option value='1'>Store</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Book status :- </td>
                                    <td>
                                        <select name='bstatus' required>
                                            <option value='0'>Booked</option>
                                            <option value='1'>AVL</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>";
        }else{
            $GLOBALS['output'].= "<tr>
                                    <td>Book location :- </td>
                                    <td>
                                        <select name='blocation' required>
                                            <option value='0'>Inventory</option>
                                            <option value='1'>Store</option>
                                        </select>
                                    </td>
                                </tr>";
        }
        $GLOBALS['output'] .="</tbody></table>
                            <div><button type='submit' name='submit'>update</button></div></form>";
    }
    function order() {
        $order = substr($GLOBALS['id'],0,2);
        $GLOBALS['output'] .= "<h3>Edit-Order-Data</h3><form>
                                <table>
                                    <tbody>";
        if($order == "OS"){
            $select = "select * from sell_order where Order_id = '{$GLOBALS['id']}'";
            $select1 = "select Admin_id,Admin_first_name,Admin_last_name,Admin_designation from admin where Admin_designation = 'pickup executive'";
        }else{
            $select = "select * from buy_order where Order_id = '{$GLOBALS['id']}'";
            $select1 = "select Admin_id,Admin_first_name,Admin_last_name,Admin_designation from admin where Admin_designation = 'delivery executive'";
        }
        $query = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "view error");
        $row = mysqli_fetch_assoc($query);
        $GLOBALS['output'] .=   "   
                                        <input type='text' id='oid' value='{$row['Order_id']}' hidden>
                                        <tr>
                                            <td>Order Id :- </td>
                                            <td>{$row['Order_id']}</td>
                                        </tr>
                                        <tr>
                                            <td>Customer Id :- </td>
                                            <td>{$row['Customer_id']}</td>
                                        </tr>";
                                        if($order == "OS"){
                                        $GLOBALS['output'] .=   "   <tr>
                                                <td>Book Id :- </td>
                                                <td>{$row['Book_id']}</td>
                                            </tr>";
                                    }
        $address = mysqli_query($GLOBALS['conn'], "select * from address where Address_id = '{$row['Address_id']}'");
        $row1 = mysqli_fetch_assoc($address);
        $GLOBALS['output'] .=   "   <tr>
                                            <td>Dilevery Address :- </td>
                                            <td><table>
                                                    <tr>
                                                        <th>Address line 1 :- </th>
                                                        <td><input type='text' id='address1' value='{$row1['Address_line_1']}'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address line 2 :- </th>
                                                        <td><input type='text' id='address2' value='{$row1['Address_line_2']}'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>PIN :- </th>
                                                        <td><input type='text' id='addresspin' value='{$row1['Address_PIN']}'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>city :- </th>
                                                        <td><input type='text' id='addresscity' value='{$row1['Address_tehsil']}'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>District :- </th>
                                                        <td><input type='text' id='addressdistrict' value='{$row1['Address_district']}'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>state :- </th>
                                                        <td><input type='text' id='addressstate' value='{$row1['Address_state']}'</td>
                                                    </tr>
                                            </table></td>
                                        </tr>
                                        <tr>
                                            <td>Date Of Order :- </td>
                                            <td>{$row['Date_time_of_order']}</td>
                                        </tr>
                                        <tr>
                                            <td>Date Of Delivery :- </td>";
                                            if($order != "OS"){
                                                $GLOBALS['output'] .= "<td><input type='text' id='dodelivery' value='{$row['Date_time_of_delivery']}'></td></tr>";
                                            }else{
                                                $GLOBALS['output'] .= "<td><input type='text' id='dodelivery' value='{$row['Pickup_date_time']}'></td></tr>";
                                            }
                                            if($order != "OS"){
                                                $GLOBALS['output'] .= "<tr>
                                                                            <td>Order Price :- </td>
                                                                            <td>{$row['Order_price']}</td>
                                                                        </tr>";
                                            }
                                        $GLOBALS['output'] .= "
                                        <tr>
                                            <td>Excutive Id :- </td>
                                            <td>
                                                <select id='exdeg'>
                                                    <option>Select</option>";
        $queary2 = mysqli_query($GLOBALS['conn'], $select1) or die(mysqli_error($GLOBALS['conn']));
        if(mysqli_num_rows($queary2)>0){
            while($row2 = mysqli_fetch_assoc($queary2)){
                    $GLOBALS['output'] .= "<option value='{$row2['Admin_id']}'>{$row2['Admin_first_name']} {$row2['Admin_last_name']}</option>";
                }
            }
        $GLOBALS['output'] .= "
                                        </td>
                                            </tr>
                                            <tr>
                                                <td>Order Status :- </td>";
        if ($row['Status'] == 0) {
            $GLOBALS['output'] .= "<td>Active</td>";
        } else {
            $GLOBALS['output'] .= "<td>Completed</td>";
        }
        $GLOBALS['output'] .= "</tr>
                                        </tbody></table>
                                        <div>
                                        <button type='submit' id='update'>Update</button></div>
                                        </form>";
    }
    function excutive(){
    $ide = substr($GLOBALS['id'], 1, strlen($GLOBALS['id']));
    $order = substr($GLOBALS['id'], 1, 2);
    $GLOBALS['output'] .= "<h3>Edit-Order-Data</h3><form>
                                <table>
                                    <tbody>";
    if($order == 'OS'){
        $select = "select Order_id,Book_id from sell_order where Order_id = '{$ide}'";
    }else{
        $select = "select * from buy_order where Order_id = '{$ide}'";
    }
    $query = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "view error");
    $row = mysqli_fetch_assoc($query);
    $GLOBALS['output'] .=   "
                                <input type='text' id='oid' value='{$row['Order_id']}' hidden>
                                <tr>
                                <td>Enter OTP :- </td>
                                <td><input type='text' id='otp'></td>
                                </tr>
                                <tr>
                                    <td>Enter Amount :- </td>
                                    <td><input type='number' id='amount'></td>
                                </tr>
                                </tbody></table><div>
                                <button type='submit' id='update-e'>Update</button></div>
                                    </form>";
}
    echo $output;
?>