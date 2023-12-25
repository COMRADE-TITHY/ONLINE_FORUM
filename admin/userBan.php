<?php
$ban=false;
$unban=false;
include '../partials/_dbconnect.php';
if (isset($_POST["ban"])) {
    $user_id=$_POST['ban_id'];
    $query="UPDATE users SET is_banned=1 WHERE sno=$user_id";
    $result=mysqli_query($conn, $query);
    if ($result) {
        // echo "We updated the record Successfully";
        $ban = true;
        if (isset($_SESSION["loggedin"])) {
            unset($_SESSION["loggedin"]);
        }
    } else {
        echo "We could not update the record Successfully";
    }
  
}
if (isset($_POST["unban"])) {
    $user_id=$_POST['ban_id'];
    $query="UPDATE users SET is_banned=0 WHERE sno=$user_id";
    $result=mysqli_query($conn, $query);
    if ($result) {
        // echo "We updated the record Successfully";
        $unban = true;
    } else {
        echo "We could not update the record Successfully";
    }
    
  
}
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
?>