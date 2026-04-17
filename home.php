<?php
include 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home - Candle Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #8C7AA9;
        }

        .welcome {
            text-align: center;
            background-color: #fff;
            color: #38302E;
            font-size: 22px;
            font-weight: 600;
            padding: 15px 0;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .banner {
            background-image: url('uploads/banner.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-color: #8C7AA9;
            height: 70vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }

        .banner h1 {
          color:black;
            font-size: 70px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
            margin: 0;
        }

        .banner p {
            color:black;
            font-size: 23px;
            margin-top: 10px;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.5);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: white;
            font-size:35px;
            font-weight:bolder;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .product-card h3 {
            margin: 15px 0 5px 0;
            color: black;
        }

        .product-card p {
            padding: 0 15px 15px 15px;
            color: black;
            font-size: 18px;
        }

        .product-card button {
            margin-bottom: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background-color: #987B71;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .product-card button:hover {
            background-color: #38302E;
        }

        .about {
            background-color: #38302E;
            color: white;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            margin: 50px 0;
        }

        .about p {
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        footer a {
            color: #3A8DFF;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .shop-now-btn {
            display: inline-block;
            padding: 15px 30px;
            background-color: #987B71;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .shop-now-btn:hover {
            background-color: #38302E;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?> 

<!-- Welcome Message -->
<div class="welcome">
 <?php echo "Welcome, " . htmlspecialchars($user) . "!"; ?>
</div>

<!-- Banner -->
<div class="banner">
    <div>
        <h1>CANDLE BLOSSOM</h1>
        <p>Light up your life with handmade, scented candles</p>
        <a href="products.php" class="shop-now-btn">Shop Now</a>
    </div>
</div>

<!-- Featured Products -->
<div class="container">
    <h2>Our Bestsellers</h2>
    <div class="products">
        <div class="product-card">
            <img src="uploads/lavender.webp" alt="Lavender Candle">
            <h3>Lavender Bliss</h3>
            <p>Relaxing lavender-scented candle to calm your mind and space.</p>
        </div>
        <div class="product-card">
            <img src="uploads/vanilla.webp" alt="Vanilla Candle">
            <h3>Vanilla Dream</h3>
            <p>Sweet vanilla aroma to fill your room with warmth and coziness.</p>
        </div>
        <div class="product-card">
            <img src="uploads/rose.webp" alt="Rose Candle">
            <h3>Rose Elegance</h3>
            <p>Romantic rose-scented candle for special moments and décor.</p>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="about">
    <h2>About Candle Blossom</h2>
    <p>
        At Candel Blossom, we craft premium handmade candles using natural ingredients and soothing fragrances. Our candles are designed to bring warmth, calmness, and beauty to every home. Each candle is carefully made to create the perfect ambiance for relaxation, meditation, or special occasions.
    </p>
</div>

<!-- Simple Footer -->
<footer style="background:#1a1a1a; color:white; padding:20px 0; text-align:center; font-family:Arial, sans-serif;">
    &copy; 2025 Candel Blossom. All rights reserved.
</footer>

</body>
</html>
