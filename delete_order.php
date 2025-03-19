<?php
include 'includes/db.php'; // Database connection
include 'includes/auth.php'; // Authentication functions
require_admin(); // Restrict to admins only

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    if ($stmt->execute()) {
        header('Location: manage_orders.php?message=Order deleted successfully');
    } else {
        header('Location: manage_orders.php?error=Error deleting order');
    }
    $stmt->close();
} else {
    header('Location: manage_orders.php');
}
?>