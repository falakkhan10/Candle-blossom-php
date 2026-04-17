<?php

?>
<!-- Sidebar -->
<div class="sidebar">
    <h3 class="text-center">Admin Panel</h3>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_products.php">Manage Products</a>
    <a href="add_product.php">Add Product</a>
    <a href="admin_logout.php">Logout</a>
</div>

<!-- Top Navbar -->
<div class="top-navbar">
    <h3>Welcome, <?php echo $_SESSION['admin']; ?></h3>
    <div>
        <a href="admin_dashboard.php">Home</a>
        <a href="admin_logout.php">Logout</a>
    </div>
</div>

<style>
body {margin:0; display:flex; font-family:'Segoe UI'; background:#f0f2f5;}
.sidebar {width:220px; background:#1a1a1a; color:white; display:flex; flex-direction:column; padding:20px 0;}
.sidebar a {color:white; padding:12px 20px; text-decoration:none; margin:2px 0; transition:0.3s;}
.sidebar a:hover {background:#6a0dad; border-radius:5px;}
.top-navbar {height:60px; background:black; color:white; display:flex; align-items:center; justify-content:space-between; padding:0 20px;}
.top-navbar a {color:white; text-decoration:none; margin-left:15px;}
.top-navbar a:hover{color:#6a0dad;}
.dashboard-content {padding:20px; flex:1;}
.main-content {flex:1; display:flex; flex-direction:column;}
</style>
