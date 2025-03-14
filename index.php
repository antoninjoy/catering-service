<?php
include 'includes/auth.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Catering Service</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Welcome to Catering Service</h1>
    <?php if (is_logged_in()): ?>
        <p><a href="menu.php">View Menu</a> | <a href="cart.php">Cart</a> | <a href="logout.php">Logout</a></p>
    <?php else: ?>
        <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
    <?php endif; ?>
</body>
</html>