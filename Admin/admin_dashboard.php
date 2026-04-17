<?php
session_start();
include 'config.php';

// Agar admin login nahi hai to login page bhejo
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// ✅ Update order status (Confirm/Reject/Deliver)
if (isset($_GET['action']) && isset($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']);
    $action = $_GET['action'];

    if ($action == "confirm") {
        $conn->query("UPDATE orders_detail SET status='Confirmed' WHERE id=$orderId");
    } elseif ($action == "reject") {
        $conn->query("UPDATE orders_detail SET status='Rejected' WHERE id=$orderId");
    } elseif ($action == "deliver") {
        $conn->query("UPDATE orders_detail SET status='Delivered' WHERE id=$orderId");
    }
    header("Location: admin_dashboard.php"); // refresh
    exit;
}

// ✅ Total Users
$totalUsers = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];

// ✅ Total Products
$totalProducts = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];

// ✅ Total Orders
$totalOrders = $conn->query("SELECT COUNT(*) as total FROM orders_detail")->fetch_assoc()['total'];

// ✅ Recent Orders (last 5 with user info & products + status)
$recentOrders = $conn->query("
    SELECT o.id AS order_id, o.fullname, o.phone, o.address, o.payment_method, o.status,
           GROUP_CONCAT(CONCAT(oi.product_name, ' (x', oi.quantity, ')') SEPARATOR ', ') AS products
    FROM orders_detail o
    JOIN order_items oi ON oi.order_id = o.id
    GROUP BY o.id
    ORDER BY o.id DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { margin:0; height:100vh; display:flex; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f8f9fa; }
        .sidebar { width: 240px; background: #1a1a1a; color: white; display: flex; flex-direction: column; padding: 20px 0; position: fixed; top: 0; bottom: 0; }
        .sidebar h3 { text-align:center; margin-bottom:20px; font-weight:bold; }
        .sidebar a { color: white; padding: 12px 20px; text-decoration: none; margin: 2px 0; display:block; transition: 0.3s; }
        .sidebar a:hover { background: #6a0dad; border-radius: 5px; }
        .main-content { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }
        .top-navbar { height: 60px; background: #000; color: white; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; }
        .top-navbar a { color: white; text-decoration: none; margin-left: 15px; }
        .top-navbar a:hover { color: #6a0dad; }
        .dashboard-content { padding: 20px; flex: 1; background: #f8f9fa; }
        .card-custom { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align:center; padding:20px; color:white; }
        .table-custom th { background: #6c20a3ff; color: white; }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h3>Admin Panel</h3>
    <a href="admin_products.php">📦 Manage Products</a>
    <a href="add_product.php">➕ Add Product</a>
    <a href="admin_review.php">⭐ Reviews</a>
    <a href="admin_wishlist.php">💖 Wishlist</a>
    <a href="admin_logout.php">🚪 Logout</a>
</div>

<!-- Main content -->
<div class="main-content">

    <!-- Top Navbar -->
    <div class="top-navbar">
        <h5>Welcome, <?php echo $_SESSION['admin']; ?></h5>
    </div>

    <!-- Dashboard content -->
    <div class="dashboard-content">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card-custom bg-primary">
                    <h4>Total Users</h4>
                    <p style="font-size:28px;"><?php echo $totalUsers; ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-custom bg-success">
                    <h4>Total Products</h4>
                    <p style="font-size:28px;"><?php echo $totalProducts; ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-custom bg-warning text-dark">
                    <h4>Total Orders</h4>
                    <p style="font-size:28px;"><?php echo $totalOrders; ?></p>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="mt-5">
            <h3>Recent Orders</h3>
            <table class="table table-striped table-hover table-custom mt-3">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Payment</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $recentOrders->fetch_assoc()) { ?>
                        <tr>
                            <td>#<?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['payment_method']; ?></td>
                            <td><?php echo $row['products']; ?></td>
                            <td>
                                <?php 
                                    if ($row['status'] == "Confirmed") {
                                        echo "<span class='badge bg-success'>Confirmed</span>";
                                    } elseif ($row['status'] == "Rejected") {
                                        echo "<span class='badge bg-danger'>Rejected</span>";
                                    } elseif ($row['status'] == "Delivered") {
                                        echo "<span class='badge bg-primary'>Delivered</span>";
                                    } else {
                                        echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == "Pending") { ?>
                                    <a href="?action=confirm&order_id=<?php echo $row['order_id']; ?>" class="btn btn-success btn-sm">Confirm</a>
                                    <a href="?action=reject&order_id=<?php echo $row['order_id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                <?php } elseif ($row['status'] == "Confirmed") { ?>
                                    <a href="?action=deliver&order_id=<?php echo $row['order_id']; ?>" class="btn btn-primary btn-sm">Mark as Delivered</a>
                                <?php } else { ?>
                                    <em>No Action</em>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
