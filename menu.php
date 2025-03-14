<?php
include 'includes/db.php';
include 'includes/auth.php';
require_login();

$stmt = $conn->prepare("SELECT id, name, description, price FROM menu");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        function addToCart(menuId) {
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'menu_id=' + menuId
            })
            .then(response => response.text())
            .then(data => alert(data));
        }
    </script>
</head>
<body>
    <h1>Menu</h1>
    <p><a href="cart.php">View Cart</a> | <a href="logout.php">Logout</a></p>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div>
            <h2><?php echo htmlspecialchars($row['name']); ?></h2>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <p>Price: $<?php echo number_format($row['price'], 2); ?></p>
            <button onclick="addToCart(<?php echo $row['id']; ?>)">Add to Cart</button>
        </div>
    <?php endwhile; $stmt->close(); ?>
</body>
</html>