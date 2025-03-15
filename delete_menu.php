<?php
include 'includes/db.php';
include 'includes/auth.php';
require_admin();

if (isset($_GET['id'])) {
    $menu_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param("i", $menu_id);
    if ($stmt->execute()) {
        header('Location: admin_menu.php?message=Item deleted successfully');
    } else {
        header('Location: admin_menu.php?error=Error deleting item');
    }
    $stmt->close();
} else {
    header('Location: admin_menu.php');
}
?>