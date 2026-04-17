<?php
include 'config.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    $img_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $img_name = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$img_name);
    }

    $conn->query("INSERT INTO products (name, description, price, image) VALUES ('$name','$desc','$price','$img_name')");
    $msg = "Product added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
        color: #343a40;
        min-height: 100vh;
        padding: 20px;
    }

    .form-box {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: auto;
    }

    .btn-custom {
        background: #6c757d; /* Subtle grey */
        border: none;
        color: white;
        transition: 0.3s;
    }
    .btn-custom:hover {
        background: #5a6268;
    }

    .btn-back {
        display: inline-block;
        margin-top: 15px;
        background: #198754; /* Green like manage_products back button */
        color: white;
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 5px;
        transition: 0.3s;
    }
    .btn-back:hover {
        background: #146c43;
    }

    .alert {
        margin-top: 15px;
    }
  </style>
</head>
<body>

<div class="form-box">
  <h3>Add Product</h3>
 
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <input type="text" name="name" class="form-control" placeholder="Product Name" required>
    </div>
    <div class="mb-3">
        <textarea name="description" class="form-control" placeholder="Description" required></textarea>
    </div>
    <div class="mb-3">
        <input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required>
    </div>
    <div class="mb-3">
        <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-custom w-100">Add Product</button>
  </form>

  <?php if($msg) echo "<div class='alert alert-success'>$msg</div>"; ?>

  <!-- Back to Dashboard Button -->
  <a href="admin_dashboard.php" class="btn-back">← Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
