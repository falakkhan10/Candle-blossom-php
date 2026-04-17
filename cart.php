<?php
session_start();
include 'config.php';

// Initialize cart
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Ensure each item has quantity
foreach($cart as $index => $item){
    if(!isset($item['quantity'])){
        $cart[$index]['quantity'] = 1;
    }
}
$_SESSION['cart'] = $cart;

// Handle POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Update quantity
    if (isset($_POST['update_quantity'])) {
        $index = intval($_POST['index']);
        $qty = intval($_POST['quantity']);
        if($qty > 0){
            $_SESSION['cart'][$index]['quantity'] = $qty;
        }
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

    // Remove from cart
    if (isset($_POST['remove_index'])) {
        $index = intval($_POST['remove_index']);
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

    // Order Now
    if (isset($_POST['order_now'])) {
        $fullname = trim($_POST['fullname']);
        $phone    = trim($_POST['phone']);
        $address  = trim($_POST['address']);
        $payment  = "Cash on Delivery"; // fixed

        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        if ($fullname && $phone && $address && !empty($cart)) {
            $user_email = $_SESSION['user'];
            // Step 1: Insert order into orders_detail
            $stmt = $conn->prepare("INSERT INTO orders_detail (fullname, phone, address, payment_method, total_price, user_email) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssds", $fullname, $phone, $address, $payment, $totalPrice, $user_email);
            $stmt->execute();
            $order_id = $conn->insert_id;

            // Step 2: Insert products into order_items
            foreach($cart as $item){
    $product_name = $item['name'];
    $quantity = $item['quantity'];
    $price = $item['price'];
    $total_amount = $price * $quantity;

    $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price, total_amount) VALUES (?, ?, ?, ?, ?)");
    $stmt2->bind_param("isidd", $order_id, $product_name, $quantity, $price, $total_amount);
    $stmt2->execute();
}


            // Flash message
            $_SESSION['order_msg'] = "✅ Order Successful! Total: ₹$totalPrice";
            $_SESSION['cart'] = [];
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        } else {
            $_SESSION['order_msg'] = "⚠️ Please fill all details before placing order.";
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #FDE2F3, #2F284E);
      display: flex;
      flex-direction: column;
      min-height: 100vh; /* Ensures footer goes to bottom */
    }
    .container {
      flex: 1; /* Pushes footer down */
    }
    footer {
      background: #1a1a1a; 
      color: white; 
      padding: 20px 0; 
      text-align: center; 
      width: 100%;
      font-family: Arial, sans-serif;
      margin-top: auto; /* Always stick to bottom */
    }
    .delivery-heading {
      font-weight: 700; 
      font-size: 1.5rem; /* Bigger font */
      margin-top: 30px;
    }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
  <h2>🛒 My Cart</h2>

  <!-- Flash Message -->
  <?php if(isset($_SESSION['order_msg'])): ?>
      <div class="alert alert-info"><?php echo $_SESSION['order_msg']; ?></div>
      <?php unset($_SESSION['order_msg']); ?>
  <?php endif; ?>

  <?php if (!empty($_SESSION['cart'])) { ?>
    <table class="table table-bordered">
      <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Action</th>
      </tr>
      <?php foreach ($_SESSION['cart'] as $index => $item) { ?>
        <tr>
          <td><?php echo htmlspecialchars($item['name']); ?></td>
          <td>₹<?php echo $item['price']; ?></td>
          <td>
            <form method="post" style="display:inline;">
              <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width:60px;">
              <input type="hidden" name="index" value="<?php echo $index; ?>">
              <button type="submit" name="update_quantity" class="btn btn-sm btn-info">Update</button>
            </form>
          </td>
          <td>
            <form method="post" style="display:inline;">
              <input type="hidden" name="remove_index" value="<?php echo $index; ?>">
              <button type="submit" class="btn btn-danger btn-sm">Remove</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </table>

    <?php 
        $totalPrice = 0;
        foreach($_SESSION['cart'] as $item) $totalPrice += $item['price'] * $item['quantity'];
    ?>
    <h4>Total: ₹<?php echo $totalPrice; ?></h4>

    <!-- Delivery Form -->
    <h4>📝 Delivery Details</h4>
    <form method="post" class="mt-3">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="fullname" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="text" name="phone" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Delivery Address</label>
        <textarea name="address" class="form-control" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Payment Method</label>
        <input type="text" class="form-control" value="Cash on Delivery" disabled>
      </div>

      <button type="submit" name="order_now" class="btn btn-success">✅ Place Order</button>
    </form>

  <?php } else { ?>
    <p>Your cart is empty.</p>
  <?php } ?>
</div>
<!-- Full-width Simple Footer -->
<footer style="background:#1a1a1a; color:white; padding:20px 0; text-align:center; width:100vw; font-family:Arial, sans-serif;">
    &copy; 2025 Candel Blossom. All rights reserved.
</footer>

</body>
</html>
