<?php
include '../partials/_dbconnect.php';
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['id'])) {
    $category_id = $_POST['id'];
    $sql = "select * from categories where category_id = '$category_id' limit 1";
    $result = mysqli_query($conn, $sql) or die("failed");
    while ($row = mysqli_fetch_assoc($result)) {
        $category_name = $row["category_name"];
        $category_description = $row["category_description"];
        $file_id = $row["file_id"];
        //echo "<div><b>Category Name:".$category_name."</b><p>$category_description</p></div>";
        $response = array("categoryName" => $category_name,
         "categoryDesc" => $category_description,
         "fileId" => $file_id
        );
    }
    header("Content-Type: application/json");
    echo json_encode($response);
}
//}
?>