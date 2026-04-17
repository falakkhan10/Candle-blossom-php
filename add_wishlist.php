<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user'];
$product_id = intval($_GET['id']);

// Check if product exists
$result = $conn->query("SELECT * FROM products WHERE id=$product_id");
$product = $result->fetch_assoc();

if ($product) {
    // Check if already in wishlist
    $check = $conn->query("SELECT * FROM wishlist WHERE user_email='$user_email' AND product_id=$product_id")->num_rows;

    if ($check == 0) {
        $conn->query("INSERT INTO wishlist (user_email, product_id, product_name, price, image, created_at)
                      VALUES ('$user_email', $product_id, '".$conn->real_escape_string($product['name'])."', '".$product['price']."', '".$product['image']."', NOW())");
    }
}

header("Location: wishlist.php");
exit;
?>
