<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// User email from session
$user_email = $_SESSION['user'];

// Check if form submitted
if (isset($_POST['submit_review'])) {

    $order_id = intval($_POST['order_id']);
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $rating = intval($_POST['rating']);
    $comment = $conn->real_escape_string($_POST['comment']);

    // Prevent duplicate review
    $check = $conn->query("
        SELECT * FROM reviews 
        WHERE order_id = $order_id 
          AND product_name = '$product_name' 
          AND user_email = '$user_email'
    ")->num_rows;

    if ($check == 0) {
        // Insert review with corrected values
        $conn->query("
            INSERT INTO reviews (order_id, product_name, rating, comment, created_at, user_email)
            VALUES ($order_id, '$product_name', $rating, '$comment', NOW(), '$user_email')
        ");
    }
}

// Redirect back to My Orders page
header("Location: my_orders.php");
exit;
?>
