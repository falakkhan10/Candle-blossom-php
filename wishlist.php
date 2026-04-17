<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user'];

// Handle remove from wishlist
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    $conn->query("DELETE FROM wishlist WHERE id=$remove_id AND user_email='$user_email'");
    header("Location: wishlist.php");
    exit;
}

// Get wishlist items from database
$result = $conn->query("SELECT * FROM wishlist WHERE user_email='$user_email'");
$wishlist = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wishlist[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Wishlist - Candle Blossom</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #FDE2F3, #2F284E);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .container { margin-top: 30px; flex: 1; }
    .card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .card img { border-top-left-radius: 12px; border-top-right-radius: 12px; }
    h2 { color: white; text-align: center; font-weight: bold; margin-bottom: 30px; }
    footer { background: #1a1a1a; color: white; padding: 20px 0; text-align: center; margin-top: auto; }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
  <h2>My Wishlist 💖</h2>

  <?php if (!empty($wishlist)) { ?>
    <div class="row">
      <?php foreach ($wishlist as $item) { ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <?php if (!empty($item['image'])) { ?>
              <img src="uploads/<?php echo $item['image']; ?>" class="card-img-top" height="200" style="object-fit: cover;">
            <?php } ?>
            <div class="card-body">
              <h5 class="card-title"><?php echo $item['product_name']; ?></h5>
              <p class="fw-bold">₹<?php echo $item['price']; ?></p>
              
              <form method="post" action="products.php" style="display: inline;">
                <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                <button type="submit" name="add_cart" class="btn btn-success btn-sm">Add to Cart</button>
              </form>
              
              <a href="wishlist.php?remove=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Remove</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } else { ?>
    <div class="text-center">
      <div class="alert alert-warning">
        <h4>Your wishlist is empty 💔</h4>
        <p>Start adding products to your wishlist!</p>
        <a href="products.php" class="btn btn-primary">Browse Products</a>
      </div>
    </div>
  <?php } ?>
</div>

<footer>
  &copy; 2025 Candle Blossom. All rights reserved.
</footer>
</body>
</html>
