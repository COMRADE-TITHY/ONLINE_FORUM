<?php
include '../partials/_dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // update the record
    $category_id = $_POST['category_id'];
    $category_name = addslashes($_POST['category_name']);
    $category_description = addslashes($_POST['category_description']);


    $category_name = str_replace("<", "&lt", $category_name);
    $category_name = str_replace(">", "&gt", $category_name);

    $category_description = str_replace("<", "&lt", $category_description);
    $category_description = str_replace(">", "&gt", $category_description);


    $filename = $_FILES['file_id']['name'];
    $tempname = $_FILES['file_id']['tmp_name'];
    $destination = 'image/' . $filename;
    move_uploaded_file($tempname, $destination);

    $existSql = "SELECT * FROM `categories` WHERE `category_name`='$category_name'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 1) {
        $showError = "Category name already exists";
    } else {
        if (isset($_POST['btn_post']) && $category_name != "") {
            //sql query to be executed
            $sql1 = "UPDATE  `categories` SET `category_name` = '$category_name' , `category_description`='$category_description',`file_id`='$filename' WHERE `category_id` = '$category_id'";
            $result1 = mysqli_query($conn, $sql1) or die("failed:". mysqli_error($conn));
            if ($result1) {
                // echo "We updated the record Successfully";
                $update = true;
            } else {
                echo "We could not update the record Successfully";
            }
        }

        $sql = "select * from categories where category_id = '$category_id' limit 1";
        $result = mysqli_query($conn, $sql) or die("failed");
        $row = mysqli_fetch_assoc($result);
        header("Location: category.php");
    }
}

?>