<?php
include 'config.php';

$id = $_GET['id'];
$msg = "";

$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    $img_name = $product['image'];
    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $img_name = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$img_name);
    }

    $conn->query("UPDATE products SET name='$name', description='$desc', price='$price', image='$img_name' WHERE id=$id");
    $msg = "Product updated successfully!";
    $product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {background: linear-gradient(135deg,#222,#444); color:white; min-height:100vh; padding:20px;}
    .form-box {background:#333; padding:25px; border-radius:10px;}
    .btn-custom {background:#6a0dad; border:none;}
    .btn-custom:hover {background:#580e9b;}
  </style>
</head>
<body>
<div class="container form-box">
  <h3>Edit Product</h3>
  <?php if($msg) echo "<div class='alert alert-success'>$msg</div>"; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3"><input type="text" name="name" class="form-control" value="<?php echo $product['name']; ?>" required></div>
    <div class="mb-3"><textarea name="description" class="form-control" required><?php echo $product['description']; ?></textarea></div>
    <div class="mb-3"><input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required></div>
    <div class="mb-3"><input type="file" name="image" class="form-control"></div>
    <?php if($product['image']) echo "<img src='../uploads/{$product['image']}' height='80'>"; ?>
    <button type="submit" class="btn btn-custom w-100 mt-2">Update Product</button>
  </form>
</div>
</body>
</html>
