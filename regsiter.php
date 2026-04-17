<?php
include 'config.php';

$message = ""; // yaha pe message store hoga


// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $password = $_POST['password']; // no hashing, plain text
    $city     = $_POST['city'];

    // Insert query
    $sql = "INSERT INTO users (fullname, email, password, city) 
            VALUES ('$fullname', '$email', '$password', '$city')";

    if ($conn->query($sql) === TRUE) {
        $message =  "<div class='alert alert-success text-center'>Registration successful!</div>";
    } else {
        $message =  "<div class='alert alert-danger text-center'>Error: " . $conn->error . "</div>";
    }
}
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Internal CSS -->
<style>
    body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #7b28c9ff, #FF6978);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

    .register-container {
        background: white;
        padding: 30px;
        border-radius: 10px;
        width: 400px;
        
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }
    .form-control {
        margin-bottom: 15px;
    }
    .btn-primary {
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

    .btn-primary:hover {
            background-color: #FF6978;
        }
    .login-link {
        text-align: center;
        margin-top: 10px;
    }
</style>

<div class="register-container">
    <h2>User Registration</h2>
    <form method="post">
        <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <input type="text" name="city" class="form-control" placeholder="City">
        <button type="submit" class="btn btn-primary">Register</button>

        <div class="login-link">
        Already have an account? <a href="login.php">Login here</a>
    </div>
    </form>

    <!-- Success/Error message yaha dikhaya jayega -->
    <?php if (!empty($message)) echo $message; ?>
    
</div>
