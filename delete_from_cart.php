<?php
include 'includes/db.php';
include 'includes/auth.php';
require_login();

if (isset($_GET['menu_id'])) {
    $menu_id = $_GET['menu_id'];
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND menu_id = ?");
    $stmt->bind_param("ii", $user_id, $menu_id);
    if ($stmt->execute()) {
        header('Location: cart.php?message=Item removed from cart');
    } else {
        header('Location: cart.php?error=Error removing item');
    }
    $stmt->close();
} else {
    header('Location: cart.php');
}
?>