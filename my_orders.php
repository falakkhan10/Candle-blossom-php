<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user'];

// Get user's orders
$orders = $conn->query("
    SELECT o.id AS order_id, o.fullname, o.phone, o.address, o.payment_method, o.total_price, o.status,
           GROUP_CONCAT(CONCAT(oi.product_name, ' (x', oi.quantity, ')') SEPARATOR ', ') AS products
    FROM orders_detail o
    LEFT JOIN order_items oi ON oi.order_id = o.id
    WHERE o.user_email = '$user_email'
    GROUP BY o.id
    ORDER BY o.id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders - Candle Blossom</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #FDE2F3, #2F284E);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .container { flex: 1; margin-top: 30px; }
    .order-card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .order-header { border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-bottom: 15px; }
    .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-confirmed { background: #d1edff; color: #0c5460; }
    .status-rejected { background: #f8d7da; color: #721c24; }
    .status-delivered { background: #cce5ff; color: #004085; }
    h2 { color: white; text-align: center; font-weight: bold; margin-bottom: 30px; }
    footer { background: #1a1a1a; color: white; padding: 20px 0; text-align: center; margin-top: auto; }
    textarea { width: 100%; padding: 5px; margin: 5px 0; }
    select { padding: 3px; }
    form button { margin-top: 5px; }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
  <h2>📋 My Orders</h2>

  <?php if ($orders->num_rows > 0) { ?>
    <?php while ($order = $orders->fetch_assoc()) { ?>

      <div class="order-card">
        <div class="order-header">
          <div class="row">
            <div class="col-md-6">
              <h5>Order #<?php echo $order['order_id']; ?></h5>
              <small class="text-muted">Order Date: N/A</small>
            </div>
            <div class="col-md-6 text-end">
              <span class="status-badge status-<?php echo strtolower($order['status']); ?>">
                <?php echo $order['status']; ?>
              </span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-8">
            <p><strong>Products:</strong></p>

            <?php
            $items = $conn->query("SELECT * FROM order_items WHERE order_id = ".$order['order_id']);
            while($item = $items->fetch_assoc()){
                $product_name = $conn->real_escape_string($item['product_name']);
                echo '<div style="margin-bottom:10px; padding:5px; border-bottom:1px solid #ccc;">';
                echo '<strong>'.$item['product_name'].'</strong> (x'.$item['quantity'].')<br>';

                // Check if review exists
                $checkReview = $conn->query("
                    SELECT * FROM reviews
                    WHERE order_id=".$order['order_id']."
                      AND product_name='$product_name'
                      AND user_email='$user_email'
                ")->num_rows;

                // If Delivered & not reviewed → show review form
                if($order['status'] == 'Delivered' && $checkReview == 0){
                    echo '<form method="post" action="submit_review.php">
                            <input type="hidden" name="order_id" value="'.$order['order_id'].'">
                            <input type="hidden" name="product_name" value="'.$product_name.'">
                            <label>Rating: </label>
                            <select name="rating" required>
                                <option value="">Select</option>
                                <option value="1">1⭐</option>
                                <option value="2">2⭐</option>
                                <option value="3">3⭐</option>
                                <option value="4">4⭐</option>
                                <option value="5">5⭐</option>
                            </select><br>
                            <textarea name="comment" placeholder="Write your review" required></textarea><br>
                            <button type="submit" name="submit_review" class="btn btn-primary btn-sm">Submit Review</button>
                          </form>';
                }

                // Show already submitted review
                if($checkReview > 0){
                    $reviews_query = $conn->query("
                        SELECT * FROM reviews
                        WHERE order_id=".$order['order_id']."
                          AND product_name='$product_name'
                          AND user_email='$user_email'
                    ");
                    while($review = $reviews_query->fetch_assoc()){
                        echo '<div style="margin-top:5px; padding:5px; background:#f8f9fa; border-radius:5px;">';
                        echo '✅ Rating: '.$review['rating'].'⭐<br>';
                        echo '<em>'.$review['comment'].'</em><br>';
                        echo '<small>'.$review['created_at'].' | '.$review['user_email'].'</small>';
                        echo '</div>';
                    }
                }

                echo '</div>'; // end product block
            }
            ?>

            <p><strong>Delivery Address:</strong> <?php echo $order['address']; ?></p>
            <p><strong>Phone:</strong> <?php echo $order['phone']; ?></p>
          </div>

          <div class="col-md-4 text-end">
            <h5>₹<?php echo $order['total_price']; ?></h5>
            <small><?php echo $order['payment_method']; ?></small>
          </div>
        </div>
      </div>

    <?php } ?>
  <?php } else { ?>
    <div class="text-center">
      <div class="order-card">
        <h4>No Orders Found</h4>
        <p>You haven't placed any orders yet.</p>
        <a href="products.php" class="btn btn-primary">Start Shopping</a>
      </div>
    </div>
  <?php } ?>
</div>

<footer>
  &copy; 2025 Candle Blossom. All rights reserved.
</footer>

</body>
</html>
