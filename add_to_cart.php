<?php
include 'includes/db.php';
include 'includes/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = $_POST['menu_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND menu_id = ?");
    $stmt->bind_param("ii", $user_id, $menu_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND menu_id = ?");
        $stmt->bind_param("ii", $user_id, $menu_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id, menu_id, quantity) VALUES (?, ?, 1)");
        $stmt->bind_param("ii", $user_id, $menu_id);
    }
    if ($stmt->execute()) {
        echo "Added to cart";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>