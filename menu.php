<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Redirect if not logged in
redirectIfNotLoggedIn();

// Handle "Add to Cart" action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $food_item_id = intval($_POST['food_item_id']);
    $user_id = $_SESSION['user_id'];

    // Check if the item is already in the cart
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND food_item_id = ?");
    $stmt->execute([$user_id, $food_item_id]);
    $cart_item = $stmt->fetch();

    if ($cart_item) {
        // Increase quantity if the item is already in the cart
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE id = ?");
        $stmt->execute([$cart_item['id']]);
    } else {
        // Add new item to the cart
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, food_item_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $food_item_id]);
    }
}

// Fetch food items from the database
$stmt = $pdo->query("SELECT * FROM food_items");
$food_items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Food Menu</h1>
        <div class="menu">
            <?php foreach ($food_items as $item): ?>
                <div class="item">
                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                    <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                    <form method="POST" action="">
                        <input type="hidden" name="food_item_id" value="<?php echo $item['id']; ?>">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="cart.php"><button class="cart-button">View Cart</button></a>
    </div>
</body>
</html>