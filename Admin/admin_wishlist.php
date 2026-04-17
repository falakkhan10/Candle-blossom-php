<?php
session_start();
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch all wishlist items from database
$result = $conn->query("
    SELECT w.id, w.user_email, w.product_id, w.product_name, w.price, w.image, w.created_at
    FROM wishlist w
    ORDER BY w.created_at DESC
");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }
        .container { margin-top: 40px; }
        table { background: white; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        th, td { vertical-align: middle !important; }
        img { width: 80px; height: 60px; object-fit: cover; border-radius: 5px; }
        h2 { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>

<div class="container">
    <h2>💖 All Users Wishlist</h2>
    <?php if ($result->num_rows > 0) { ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Email</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Date Added</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['user_email']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td>
                            <?php if(!empty($row['image'])) { ?>
                                <img src="../uploads/<?php echo $row['image']; ?>" alt="Product Image">
                            <?php } ?>
                        </td>
                        <td>₹<?php echo $row['price']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-info text-center">
            No wishlist items found.
        </div>
    <?php } ?>
</div>

</body>
</html>
