<?php
session_start();
include 'config.php';

// Simple admin session check - customize as per your login system
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch all reviews from database ordered by latest first
$reviews = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Panel - All Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; background: #f8f9fa; font-family: Arial, sans-serif; }
        h2 { margin-bottom: 20px; }
        table { background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        th, td { vertical-align: middle !important; }
    </style>
</head>
<body>

<h2>All User Reviews</h2>

<?php if ($reviews->num_rows > 0): ?>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>User Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $reviews->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['rating']); ?>⭐</td>
                    <td><?php echo nl2br(htmlspecialchars($row['comment'])); ?></td>
                    <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No reviews submitted yet.</p>
<?php endif; ?>

</body>
</html>
