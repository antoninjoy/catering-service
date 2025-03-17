<?php
include 'includes/db.php';
include 'includes/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity'])) {
    $user_id = $_SESSION['user_id'];
    foreach ($_POST['quantity'] as $menu_id => $quantity) {
        $quantity = (int)$quantity;
        if ($quantity > 0) {
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND menu_id = ?");
            $stmt->bind_param("iii", $quantity, $user_id, $menu_id);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND menu_id = ?");
            $stmt->bind_param("ii", $user_id, $menu_id);
            $stmt->execute();
        }
    }
    header('Location: cart.php?message=Cart updated successfully');
} else {
    header('Location: cart.php');
}
?>