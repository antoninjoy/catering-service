<?php
include 'includes/db.php';
include 'includes/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = $_POST['menu_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $user_id = $_SESSION['user_id'];

    if ($quantity < 1) {
        echo "Quantity must be at least 1";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO cart (user_id, menu_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?");
    $stmt->bind_param("iiii", $user_id, $menu_id, $quantity, $quantity);
    if ($stmt->execute()) {
        echo "Item added to cart!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>