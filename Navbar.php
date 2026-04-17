<?php
if (!isset($_SESSION)) {
    session_start();
}
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<style>
  /* Internal CSS for Navbar */
  .navbar {
    background: #000 !important; /* pure black background */
    box-shadow: 0 4px 12px rgba(0,0,0,0.4);
    padding:20px;
  }
  .navbar-brand {
    font-weight: bold;
    font-size: 22px;
    color: #b19cd9 !important; /* lavender accent */
    text-shadow: 1px 1px 5px rgba(177,156,217,0.4);
  }
  .nav-link {
    color: #ddd !important;
    font-weight: 500;
    transition: color 0.3s, background 0.3s;
    border-radius: 6px;
    margin: 0 4px;
    padding: 8px 12px !important;
  }
  .nav-link:hover {
    background: rgba(255,255,255,0.05);
    color: #fff !important;
  }
  .nav-link.active {
    color: #b19cd9 !important; /* highlight active link */
  }
  .navbar-nav .nav-item:last-child .nav-link {
    background: linear-gradient(90deg,#6a5acd,#8f7be0);
    color: white !important;
    border-radius: 8px;
    padding: 8px 14px !important;
    box-shadow: 0 3px 8px rgba(106,90,205,0.3);
  }
  .navbar-nav .nav-item:last-chil
  d .nav-link:hover {
    background: linear-gradient(90deg,#5a4bb5,#7f6ad9);
  }
</style>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Candle Blossom</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="my_orders.php">My Orders</a></li>
        
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
        <!-- <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li> -->
        <li class="nav-item">
          <a class="nav-link" href="wishlist.php">❤️ Wishlist</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">🛒 Cart (<?php echo $cart_count; ?>)</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
  
</nav>
