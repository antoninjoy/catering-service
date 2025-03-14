<?php
include 'includes/db.php';
include 'includes/auth.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO menu (name, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $description, $price);
    if ($stmt->execute()) {
        $message = "Food added successfully";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p><a href="logout.php">Logout</a></p>
    <?php 
    if (isset($message)) echo "<p style='color:green;'>$message</p>";
    if (isset($error)) echo "<p style='color:red;'>$error</p>";
    ?>
    <h2>Add Food Item</h2>
    <form method="post">
        <label for="name">Food Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" step="0.01" required><br>
        <button type="submit">Add Food</button>
    </form>
</body>
</html>