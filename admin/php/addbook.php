<?php
include "config.php";
class store
{
    private $id="";
    private $btitle = "";
    private $bauthor = "";
    private $bdesc = "";
    private $bpublisher = "";
    private $bedition = "";
    private $bpage = "";
    private $category = "";
    private $subcategory = "";
    private $subbook = "";
    private $bmrp = "";
    private $bcost = "";
    private $bsell = "";

    private $output = "";
    public function displayform()
    {
        $this->output .= " <div class='form-info'>
                                    <button id='close'><i class='fa-solid fa-xmark'></i></button>
                                        <form id='submit-form' enctype='multipart/form-data'>
                                            <h3>Add-Books</h3>
                                                <div id='prev'>
                                                    <div>
                                                        <input type='text' placeholder='Enter book title' name='btitle' required>
                                                    </div>
                                                    <div>
                                                        <input type='text' placeholder='Enter book author name' name='bauthor' required>
                                                    </div>
                                                    <div>
                                                        <textarea type='text' placeholder='Enter book description' name='bdesc' rows=10 required></textarea>
                                                    </div>
                                                    <div>
                                                        <input type='text' placeholder='Enter book publisher name' name='bpublisher' required>
                                                    </div>
                                                    <div>
                                                        <input type='number' placeholder='Enter book edition' name='bedition' required>
                                                    </div>
                                                    <div>
                                                        <input type='number' placeholder='Enter book total page' name='bpage' required>
                                                    </div>
                                                    <div>
                                                        <select name='category' required>";
        $select = "select * from category_1";
        $queary = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "category,subcategory and subject book fault");
        if (mysqli_num_rows($queary) > 0) {
            $this->output .= "<option>select</option>";
            while ($row = mysqli_fetch_assoc($queary)) {
                $this->output .= "<option value='{$row['Category_id']}'>{$row['Category_name_1']}</option>";
            }
        }
        $this->output .= "</select></div><div><select name='subcategory' required>";
        $select = "select * from category_2";
        $queary = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "category,subcategory and subject book fault");
        if (mysqli_num_rows($queary) > 0) {
            $this->output .= "<option>select</option>";
            while ($row = mysqli_fetch_assoc($queary)) {
                $this->output .= "<option value='{$row['Category_id']}'>{$row['Category_name_2']}</option>";
            }
        }
        $this->output .= "</select></div><div><select name='subbook' required>";
        $select = "select * from category_3";
        $queary = mysqli_query($GLOBALS['conn'], $select) or die(mysqli_error($GLOBALS['conn']) . "category,subcategory and subject book fault");
        if (mysqli_num_rows($queary) > 0) {
            $this->output .= "<option>select</option>";
            while ($row = mysqli_fetch_assoc($queary)) {
                $this->output .= "<option value='{$row['Category_id']}'>{$row['Category_name_3']}</option>";
            }
        }
        $this->output .= "</select></div></div><div id='next' hidden>
                                                <div>
                                                    <input type='number' placeholder='Enter book MRP' name='bmrp' required>
                                                </div>
                                                <div>
                                                    <input type='number' placeholder='Enter book cost price' name='bcost' required>
                                                </div>
                                                <div>
                                                    <input type='number' placeholder='Enter book sell price' name='bsell' required>
                                                </div>
                                                <div class='image'>
                                                    <table>
                                                        <tr>
                                                            <td><lable>Book front image </lable></td>
                                                            <td><input type='file' name='bfront' required></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class='image'>
                                                    <table>
                                                        <tr>
                                                            <td><lable>Book back image </lable></td>
                                                            <td><input type='file' name='bback' required></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class='image'>
                                                    <table>
                                                        <tr>
                                                            <td><lable>Book MRP page image </lable></td>
                                                            <td><input type='file' name='bmrpi' required></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class='image'>
                                                    <table>
                                                        <tr>
                                                            <td><lable>Book edition page image </lable></td>
                                                            <td><input type='file' name='beditioni' required></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class='image'>
                                                    <table>
                                                        <tr>
                                                            <td><lable>Book index pages image </lable></td>
                                                            <td><input type='file' name='index[]' multiple  required></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div>
                                                    <button type='submit' id='add-book'>Submit</button>
                                                </div>
                                            </div>
                                            <button id='prev-btn' hidden>Prev</button>
                                            <button id='next-btn'>Next</button>
                                        </form>
                                </div>";
        return $this->output;
    }
    public function insertbook($id,$btitle, $bauthor, $bdesc, $bpublisher, $bedition, $bpage, $category, $subcategory, $subbook, $bmrp, $bcost, $bsell,array $new_book_image)
    {
        $this->id= mysqli_real_escape_string($GLOBALS['conn'], $id);
        $this->btitle = mysqli_real_escape_string($GLOBALS['conn'], $btitle);
        $this->bauthor = mysqli_real_escape_string($GLOBALS['conn'], $bauthor);
        $this->bdesc = mysqli_real_escape_string($GLOBALS['conn'], $bdesc);
        $this->bpublisher = mysqli_real_escape_string($GLOBALS['conn'], $bpublisher);
        $this->bedition = mysqli_real_escape_string($GLOBALS['conn'], $bedition);
        $this->bpage = mysqli_real_escape_string($GLOBALS['conn'], $bpage);
        $this->category = mysqli_real_escape_string($GLOBALS['conn'], $category);
        $this->subcategory = mysqli_real_escape_string($GLOBALS['conn'], $subcategory);
        $this->subbook = mysqli_real_escape_string($GLOBALS['conn'], $subbook);
        $this->bmrp = mysqli_real_escape_string($GLOBALS['conn'], $bmrp);
        $this->bcost = mysqli_real_escape_string($GLOBALS['conn'], $bcost);
        $this->bsell = mysqli_real_escape_string($GLOBALS['conn'], $bsell);
        
        $insert = "insert into book(Book_id,Book_title,Book_author,Book_description,Book_publisher,Book_edition,Book_category_1,Book_category_2,Book_category_3,Book_pages,Book_MRP,Book_CP,Book_SP,Book_location,Book_status) values('{$this->id}','{$this->btitle}','{$this->bauthor}','{$this->bdesc}','{$this->bpublisher}',{$this->bedition},{$this->category},{$this->subcategory},{$this->subbook},{$this->bpage},'{$this->bmrp}','{$this->bcost}','{$this->bsell}',1,1)";
        $queary = mysqli_query($GLOBALS['conn'], $insert) or die(mysqli_error($GLOBALS['conn']) . "book insert error");
        if ($queary) {
            $j = 0;
            while ($j < sizeof($new_book_image)) {
                $image = $new_book_image[$j];
                $type = end(explode('-',$new_book_image[$j]));
                $substr = substr($type,0,1);

                $insert_i = "insert into book_image(Book_id,image_name,Image_type) values('{$this->id}','{$image}','{$substr}')";

                mysqli_query($GLOBALS['conn'], $insert_i) or die(mysqli_error($GLOBALS['conn']) . "book insert error");
                $j++;
            }
        } else {
            echo "error";
        }
    }
}
$addbook = new store();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    $id = "insertbook";
}
switch ($id) {
    case 'addbook':
        echo $addbook->displayform();
        break;
    case 'insertbook':
        $btitle = $_POST['btitle'];
        $bauthor = $_POST['bauthor'];
        $bdesc = $_POST['bdesc'];
        $bpublisher = $_POST['bpublisher'];
        $bedition = $_POST['bedition'];
        $bpage = $_POST['bpage'];
        $category = $_POST['category'];
        $subcategory = $_POST['subcategory'];
        $subbook = $_POST['subbook'];
        $bmrp = $_POST['bmrp'];
        $bcost = $_POST['bcost'];
        $bsell = $_POST['bsell'];
        $id = "B-".mt_rand();
        if (isset($_FILES['bfront'], $_FILES['bback'], $_FILES['bmrpi'], $_FILES['beditioni'], $_FILES['index'])) {
            $arrayerror = array();
            $book_image = array($_FILES['bfront'], $_FILES['bback'], $_FILES['bmrpi'], $_FILES['beditioni']);
            $new_book_image=array();
            $image = array('front', 'back', 'mrp', 'edition');

            for ($i = 0; $i < sizeof($book_image); $i++) {
                $file_name = $book_image[$i]['name'];
                $file_size = $book_image[$i]['size'];
                $file_temp = $book_image[$i]['tmp_name'];
                $file_type = $book_image[$i]['type'];

                $file_ext = end(explode('.', $file_name));

                $extension = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $extension) === false) {
                    $error[] = "this extension file is not allowed , plese choose jpg or png image";
                }
                if ($file_size > 5242880) {
                    $error[] = "file size must be less than 2MB";
                }

                $path = "../../upload/" . $id;
    
                $new_name = $id . "-".$image[$i].".{$file_ext}";
                $target = $path . "/" . $new_name;
                $new_book_image[] = $new_name;
                if(file_exists($path)){
                    if (empty($error) == true) {
                        move_uploaded_file($file_temp, $target);
                    } else {
                        print_r($error);
                        unset($error);
                    }
                }else{
                    mkdir($path);
                    if (empty($error) == true) {
                        move_uploaded_file($file_temp, $target);
                    } else {
                        print_r($error);
                        unset($error);
                    }
                }
            }
            $i=0;
            while($i<sizeof($_FILES['index']['name'])){
                $file_name = $_FILES['index']['name'][$i];
                $file_size = $_FILES['index']['size'][$i];
                $file_temp = $_FILES['index']['tmp_name'][$i];
                $file_type = $_FILES['index']['type'][$i];

                $file_ext = end(explode('.', $file_name));

                $extension = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $extension) === false) {
                    $error[] = "this extension file is not allowed , plese choose jpg or png image";
                }
                if ($file_size > 5242880) {
                    $error[] = "file size must be less than 2MB";
                }

                $path = "../../upload/" . $id;

                $new_name = $id . "-index{$i}.{$file_ext}";
                $target = $path . "/" . $new_name;
                $new_book_image[] = $new_name;
                if (file_exists($path)) {
                    if (empty($error) == true) {
                        move_uploaded_file($file_temp, $target);
                    } else {
                        print_r($error);
                        unset($error);
                    }
                } else {
                    mkdir($path);
                    if (empty($error) == true) {
                        move_uploaded_file($file_temp, $target);
                    } else {
                        print_r($error);
                        unset($error);
                    }
                }
                $i++;
            }
            $addbook->insertbook($id,$btitle, $bauthor, $bdesc, $bpublisher, $bedition, $bpage, $category, $subcategory, $subbook, $bmrp, $bcost, $bsell, $new_book_image);
        }
        break;
}
?>