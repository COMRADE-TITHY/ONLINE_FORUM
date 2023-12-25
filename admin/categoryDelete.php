<?php
$delete = false;
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
include '../partials/_dbconnect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['delete'])) {
    $category_del_id =$_POST['category_del_id'];
    echo "Hello".$category_del_id;
    $delete = true;
    $sql = "DELETE FROM `categories` WHERE `category_id` = '$category_del_id'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    
    header("Location: category.php");
    }
}
?>
