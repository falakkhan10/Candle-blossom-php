<?php
session_start();
session_destroy();  // सभी session variables clear कर देगा
header("Location: admin_login.php");  // redirect to login page
exit;
