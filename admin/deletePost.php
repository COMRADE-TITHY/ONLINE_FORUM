<?php
if (isset($_POST["delete"]) && (isset($_POST['selected_threads']) || isset( $_POST['selected_comments']))) {
    include('../partials/_dbconnect.php');
    foreach ($_POST['selected_threads'] as $item) {
        $query="DELETE FROM `threads` WHERE thread_id=$item";
        $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
    }
    foreach ($_POST['selected_comments'] as $item) {
        $query="DELETE FROM `comments` WHERE comment_id=$item";
        $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
    }
}
header("Location: post.php");
?>