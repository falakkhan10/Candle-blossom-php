<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Candle Blossom</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #FDE2F3, #2F284E);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh; /* Footer bottom */
    }
    .container {
      flex: 1; /* Content expand karega */
    }
    .contact-container {
      background: #fff;
      padding: 40px;
      margin: 50px auto;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      max-width: 700px;
      text-align: center;
    }
    h2 {
      color: #2F284E;
      font-weight: bold;
      margin-bottom: 25px;
    }
    .info-box {
      margin: 20px 0;
      padding: 20px;
      border-radius: 12px;
      background: #f8f9fa;
    }
    .info-box h5 {
      color: #2F284E;
      margin-bottom: 8px;
    }
    .info-box p {
      margin: 0;
      font-size: 16px;
    }
    footer {
      background: #1a1a1a;
      color: white;
      padding: 20px 0;
      text-align: center;
      width: 100%;
      margin-top: auto; /* Footer always bottom */
      font-family: Arial, sans-serif;
    }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
  <div class="contact-container">
    <h2> Contact Us</h2>
    <p>
      We’d love to hear from you! Whether you have a question about our candles, 
      need support, or just want to share your thoughts — the Candle Blossom team is here to help. 🌸
    </p>

    <div class="info-box">
      <h5>📍 Our Address</h5>
      <p>Candle Blossom<br>123 Blossom Street,<br>Navsari, Gujarat – 396445</p>
    </div>

    <div class="info-box">
      <h5>📧 Email</h5>
      <p>support@candleblossom.com</p>
    </div>

    <div class="info-box">
      <h5>📱 Phone</h5>
      <p>+91 98765 43210</p>
    </div>

  </div>
</div>

<!-- Sticky Footer -->
<footer>
    &copy; 2025 Candel Blossom. All rights reserved.
</footer>

</body>
</html>
