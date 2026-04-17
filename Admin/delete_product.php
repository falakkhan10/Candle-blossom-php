<?php
include 'config.php';

$id = $_GET['id'];

// Optional: Delete image file
$row = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
if ($row['image'] && file_exists("../uploads/".$row['image'])) {
    unlink("../uploads/".$row['image']);
}

$conn->query("DELETE FROM products WHERE id=$id");
header("Location: admin_products.php");
exit;
