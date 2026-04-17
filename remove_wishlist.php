<?php
session_start();
include "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);
$user_email = $_SESSION['user'];

// Delete wishlist item only for this user
$conn->query("DELETE FROM wishlist WHERE id=$id AND user_email='$user_email'");

header("Location: wishlist.php");
exit;
?>
