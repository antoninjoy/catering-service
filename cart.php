<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Redirect if not logged in
redirectIfNotLoggedIn();

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$stmt = $pdo->prepare("
    SELECT c.id, f.name, f.price, c.quantity, c.added_at
    FROM cart c
    JOIN food_items f ON c.food_item_id = f.id
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <?php if (count($cart_items) > 0): ?>
            <ul>
                <?php foreach ($cart_items as $item): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($item['name']); ?></strong> - 
                        $<?php echo number_format($item['price'], 2); ?> x 
                        <?php echo $item['quantity']; ?> - 
                        Added on <?php echo date('Y-m-d H:i', strtotime($item['added_at'])); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="place_order.php"><button class="cart-button">Place Order</button></a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
        <a href="menu.php"><button class="cart-button">Back to Menu</button></a>
    </div>
</body>
</html>