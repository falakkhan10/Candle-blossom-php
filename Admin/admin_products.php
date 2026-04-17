<?php
include 'config.php';

$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Products</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    h1 {
        text-align:center;   
        margin-bottom: 20px;
        font-weight: bold;
        color: #343a40;
    }

    .main-content {
        padding: 30px;
    }

    .back_link {
        display: inline-block;
        padding:8px 16px;
        background: #198754;
        color:white;
        text-decoration:none;
        border-radius:5px;
        font-size:14px;
        transition:0.3s;
        margin-bottom: 20px;
    }
    .back_link:hover {
        background: #146c43;
    }

    .table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .table th {
        background-color: #198754;
        color: white;
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        text-align: center;
        vertical-align: middle;
    }

    .btn-sm {
        padding: 4px 10px;
        border-radius: 5px;
    }

    img {
        border-radius: 5px;
        border: 1px solid #ddd;
    }
</style>
</head>
<body>

<div class="main-content">
    <h1>Manage Products</h1>
    <a href="admin_dashboard.php" class="back_link">← Back To Dashboard</a>
    <div class="container mt-4">
        <!-- <a href="add_product.php" class="btn btn-success mb-3">+ Add Product</a> -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="25%">Name</th>
                    <th width="15%">Price</th>
                    <th width="20%">Image</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>₹<?php echo $row['price']; ?></td>
                    <td>
                        <?php if($row['image']) echo "<img src='../uploads/{$row['image']}' height='50'>"; ?>
                    </td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['id'];?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="delete_product.php?id=<?php echo $row['id'];?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
