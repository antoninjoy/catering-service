<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address']);
    $total_amount = floatval($_POST['total_amount']);

    $stmt = $pdo->prepare("INSERT INTO orders (user_id, address, total_amount) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $address, $total_amount]);
    echo "<h1>Order Placed Successfully!</h1>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Place Order</h1>
    <form method="POST" action="">
        <label>Delivery Address:</label>
        <textarea name="address" required></textarea><br>
        <label>Total Amount:</label>
        <input type="number" step="0.01" name="total_amount" required><br>
        <button type="submit">Place Order</button>
    </form>
</body>
</html>