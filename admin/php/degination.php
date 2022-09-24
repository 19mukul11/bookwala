 <?php
    include "config.php";
    $output = "<select id='deg' required>
                    <option>Degination</option>";
    $select = "select Dign_name from designation";
    $queary = mysqli_query($conn,$select) or die(mysqli_error($conn)."degination error");
    if(mysqli_num_rows($queary)>0){
        while($row = mysqli_fetch_assoc($queary)){
            $output .= "<option value='{$row['Dign_name']}'>{$row['Dign_name']}</option>";
        }
    }
    $output.="</select>";
    echo $output;
?>