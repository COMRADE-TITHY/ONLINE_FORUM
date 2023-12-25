<?php
$delete = false;
include '_dbconnect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['delete'])) {
    $comment_del_id = $_POST['comment_del_id'];
    $delete = true;
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your comment has been deleted successfully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    }
    $sql = "DELETE FROM `comments` WHERE `comment_id` = '$comment_del_id'";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
}
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");

}

?>