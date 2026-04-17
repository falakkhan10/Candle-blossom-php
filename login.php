<?php
include 'config.php';

// Check login form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password']; // plain text compare

    // Query to check user
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Store user session
        $_SESSION['user'] = $email;
        header("Location: home.php");
        exit;
    } else {
        echo "Invalid email or password!";
    }
}
?>

<!-- Login Form -->
<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <style>
        /* Body styling */
        body {
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
             background: linear-gradient(135deg, #7b28c9ff, #FF6978);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Form container */
        .login-container {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        /* Heading */
        h2 {
            color: #333;
            margin-bottom: 25px;
        }

        /* Input fields */
        input[type="email"],
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

       
        /* Button */
        button {
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

        button:hover {
            background-color: #FF6978;
        }

        /* Message styling */
        .msg {
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        p {
        margin-top: 20px;
        font-size: 14px;
    }

    p a {
        color: #3A8DFF;
        text-decoration: none;
    }

    p a:hover {
        text-decoration: underline;
    }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>User Login</h2>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>

             <p>Don't have an account? <a href="regsiter.php">Register here</a></p>
        </form>

        <!-- <?php if($msg != ""): ?>
            <div class="msg"><?php echo $msg; ?></div>
        <?php endif; ?> -->

         <p>Want to login as <a href="./admin/admin_login.php">Admin?</a></p> 
    </div>
</body>
</html>