<?php
include 'includes/db.php';
include 'includes/auth.php';
require_login();

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = $_POST['address'];

    $stmt = $conn->prepare("SELECT SUM(m.price * c.quantity) as total FROM cart c JOIN menu m ON c.menu_id = m.id WHERE c.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_price = $row['total'];

    $stmt = $conn->prepare("INSERT INTO orders (user_id, address, total_price) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $user_id, $address, $total_price);
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, menu_id, quantity, price) SELECT ?, c.menu_id, c.quantity, m.price FROM cart c JOIN menu m ON c.menu_id = m.id WHERE c.user_id = ?");
        $stmt->bind_param("ii", $order_id, $user_id);
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $message = "Order placed successfully";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Place Order</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Place Your Order</h1>
    <p><a href="cart.php">Back to Cart</a> | <a href="logout.php">Logout</a></p>
    <?php 
    if (isset($message)) echo "<p style='color:green;'>$message</p>";
    if (isset($error)) echo "<p style='color:red;'>$error</p>";
    if (!isset($message)):
    ?>
    <form method="post">
        <label for="address">Delivery Address:</label><br>
        <textarea id="address" name="address" required></textarea><br>
        <button type="submit">Place Order</button>
    </form>
    <?php endif; ?>
</body>
</html>