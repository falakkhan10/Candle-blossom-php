<?php
session_start();
include 'config.php';

/* ---------------- ADD TO CART & BUY NOW ---------------- */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_cart'])) {
        $id = intval($_POST['product_id']);
        $result = $conn->query("SELECT * FROM products WHERE id=$id");
        $product = $result->fetch_assoc();
        if ($product) {
            $_SESSION['cart'][] = $product;
            $msg = "✅ " . $product['name'] . " added to cart!";
        }
    }

    if (isset($_POST['buy_now'])) {
        $id = intval($_POST['product_id']);
        $result = $conn->query("SELECT * FROM products WHERE id=$id");
        $product = $result->fetch_assoc();
        if ($product) {
            $_SESSION['cart'][] = $product;
        }
        header("Location: cart.php");
        exit;
    }
}

/* ---------------- SEARCH + CATEGORY + SORT ---------------- */
$search   = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$sort     = $_GET['sort'] ?? '';

$sql = "SELECT * FROM products WHERE 1";

if (!empty($category)) {
    $sql .= " AND category='$category'";
}

if (!empty($search)) {
    $sql .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
}

// Sorting
if ($sort == "price_asc") {
    $sql .= " ORDER BY price ASC";
} elseif ($sort == "price_desc") {
    $sql .= " ORDER BY price DESC";
}

$products = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Products - Candle Shop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: white; }
.container { width: 90%; max-width: 1200px; margin: 30px auto; }
.search-bar { text-align: center; margin-bottom: 25px; }
.search-bar input, .search-bar select { padding: 10px; border: 2px solid black; border-radius: 8px; font-size: 16px; margin-left:5px; }
.search-bar button { padding: 10px 15px; border: none; border-radius: 8px; background-color: #38302E; color: white; font-size: 15px; cursor: pointer; margin-left:5px; }
.search-bar button:hover { background-color: #302928; }
h2 { text-align:center; font-size:50px; font-weight:bolder; margin-bottom:20px; }
.row { display:flex; flex-wrap:wrap; gap:20px; justify-content:center; }
.card { width:350px; border-radius:15px; border:2px solid #e6e0f8; box-shadow:0 6px 15px rgba(0,0,0,0.15); transition: transform 0.3s; }
.card:hover { transform:translateY(-5px); }
.card img { width:100%; height:220px; object-fit:cover; margin-top:10px; }
.card-body { padding:20px; }
.card-title { text-align:center; font-weight:bold; }
.card-text { text-align:center; }
.fw-bold { text-align:center; }
.add-cart, .buy-now { width:100%; padding:10px; border:none; border-radius:8px; color:white; margin-top:5px; }
.add-cart { background-color:#38302E; }
.buy-now { background-color:#ff4d6d; }
.wishlist-btn { display:block; text-align:center; margin-top:10px; padding:10px; border:2px solid #ff4d6d; border-radius:8px; color:#ff4d6d; text-decoration:none; }
.wishlist-btn:hover { background:#ff4d6d; color:white; }
</style>
</head>
<body>

<?php include 'Navbar.php'; ?>

<div class="container">
<h2>Our Products</h2>

<!-- SEARCH + CATEGORY + CONDITIONAL SORT -->
<div class="search-bar">
<form method="get">
    <!-- Search -->
    <input type="text" name="search" placeholder="Search candles..." value="<?php echo htmlspecialchars($search); ?>">

    <!-- Category -->
    <select name="category" onchange="this.form.submit()">
        <option value=""> Category</option>
        <option value="SHOT GLASS CANDLES" <?php if($category=="SHOT GLASS CANDLES") echo "selected"; ?>>Shot Glass Candles</option>
        <option value="PILLAR CANDLES" <?php if($category=="PILLAR CANDLES") echo "selected"; ?>>Pillar Candles</option>
        <option value="FLOATING CANDLES" <?php if($category=="FLOATING CANDLES") echo "selected"; ?>>Floating Candles</option>
        <option value="TIN CANDLES" <?php if($category=="TIN CANDLES") echo "selected"; ?>>Tin Candles</option>
        <option value="DIYAS" <?php if($category=="DIYAS") echo "selected"; ?>>Diyas</option>
    </select>

    <!-- Sort: Only visible if category selected -->
    <?php if(!empty($category)) { ?>
    <select name="sort" onchange="this.form.submit()">
        <option value="">Sort By</option>
        <option value="price_asc" <?php if($sort=="price_asc") echo "selected"; ?>>Price: Low to High</option>
        <option value="price_desc" <?php if($sort=="price_desc") echo "selected"; ?>>Price: High to Low</option>
    </select>
    <?php } ?>

    <button type="submit">🔍 Search</button>
</form>
</div>

<div class="row">
<?php
if ($products->num_rows > 0) {
    while ($row = $products->fetch_assoc()) {
?>
<div class="card">
    <?php if ($row['image']) { ?>
        <img src="uploads/<?php echo $row['image']; ?>" alt="Candle">
    <?php } ?>
    <div class="card-body">
        <h5 class="card-title"><?php echo $row['name']; ?></h5>
        <p class="card-text"><?php echo $row['description']; ?></p>
        <p class="fw-bold">₹<?php echo $row['price']; ?></p>

        <form method="post">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <button name="add_cart" class="add-cart">Add to Cart</button>
        </form>

        <form method="post">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <button name="buy_now" class="buy-now">Buy Now</button>
        </form>

        <a href="add_wishlist.php?id=<?php echo $row['id']; ?>" class="wishlist-btn">♥ Add to Wishlist</a>
    </div>
</div>
<?php
    }
} else {
    echo "<p style='text-align:center'>No products found</p>";
}
?>
</div>
</div>

</body>

<footer style="background:#1a1a1a; color:white; text-align:center; padding:20px;">
&copy; 2025 Candle Blossom. All rights reserved.
</footer>
</html>
