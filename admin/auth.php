<?php
session_start();
if (empty($_SESSION['admin_user_id'])) {
    // The username session key does not exist or it's empty.
    header('location: /forum/admin/login.php');
    exit;
}
?>