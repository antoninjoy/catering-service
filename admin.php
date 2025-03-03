<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

// Redirect if not logged in or not an admin
redirectIfNotLoggedIn();
if (!isAdmin()) {
    header("Location: index.php");
    exit;
}

// Handle form submission to add a new food item
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);

    // Validate inputs
    if (empty($name) || empty($description) || $price <= 0) {
        $error = "All fields are required, and price must be greater than 0.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO food_items (name, description, price) VALUES (?, ?, ?)");
            $stmt->execute([$name, $description, $price]);
            $success = "Food item added successfully!";
        } catch (PDOException $e) {
            $error = "Failed to add food item: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <p>Welcome, Admin!</p>
        <a href="logout.php"><button>Logout</button></a>
    </header>

    <main>
        <section>
            <h2>Add New Food Item</h2>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label>Name:</label>
                <input type="text" name="name" required><br>
                <label>Description:</label>
                <textarea name="description" required></textarea><br>
                <label>Price ($):</label>
                <input type="number" step="0.01" name="price" min="0" required><br>
                <button type="submit">Add Food Item</button>
            </form>
        </section>

        <section>
            <h2>Current Menu</h2>
            <?php
            $stmt = $pdo->query("SELECT * FROM food_items");
            $food_items = $stmt->fetchAll();
            if (count($food_items) > 0): ?>
                <ul>
                    <?php foreach ($food_items as $item): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($item['name']); ?></strong> - 
                            <?php echo htmlspecialchars($item['description']); ?> - 
                            $<?php echo number_format($item['price'], 2); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No food items available in the menu.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Catering Service. All rights reserved.</p>
    </footer>
</body>
</html>