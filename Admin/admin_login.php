<?php
include 'config.php';


$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $msg = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background:linear-gradient(135deg, #7b28c9ff, #FF6978) ;
      color: white;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-box {
      background: white;
      padding: 25px;
      border-radius: 10px;
      width: 350px;
    
    }
    .btn-custom {
           width: 100%;
            padding: 12px;
            margin-top: 15px;
            background-color:  #350068;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
    }

    .btn-custom:hover {
    background-color: #FF6978;  /* change background */
    transform: scale(1.03);     /* slight zoom effect */
}
    /* Heading */
        h3 {
            color: #333;
            margin-bottom: 25px;
            font-weight:bolder;
        }

     .form-label{
      color: #333;
     }   

     input[type="text"],
     input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid black;
            box-sizing: border-box;
            transition: 0.3s;
            font-size:15px;
     }

     .form-label{
      text-size:18px;
      font-weight:bold;
     }
  </style>
</head>
<body>
  <div class="login-box">
    <h3 class="text-center mb-3">Admin Login</h3>
    <?php if ($msg) echo "<div class='alert alert-danger'>$msg</div>"; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-custom w-100">Login</button>
    </form>
  </div>
</body>
</html>
