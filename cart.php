<?php
include 'includes/db.php';
include 'includes/auth.php';
require_login();

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT c.menu_id, m.name, m.price, c.quantity FROM cart c JOIN menu m ON c.menu_id = m.id WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Your Cart</h1>
    <p><a href="menu.php">Back to Menu</a> | <a href="logout.php">Logout</a></p>
    <table border="1">
        <tr><th>Food</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>
        <?php while ($row = $result->fetch_assoc()): 
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>$<?php echo number_format($row['price'], 2); ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td>$<?php echo number_format($subtotal, 2); ?></td>
            </tr>
        <?php endwhile; $stmt->close(); ?>
        <tr><td colspan="3">Total</td><td>$<?php echo number_format($total, 2); ?></td></tr>
    </table>
    <a href="place_order.php"><button>Proceed to Order</button></a>
</body>
</html>