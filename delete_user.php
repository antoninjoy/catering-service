<?php
include 'includes/db.php'; // Database connection
include 'includes/auth.php'; // Authentication logic
require_admin(); // Ensure only admins can access

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        header('Location: manage_users.php?message=User deleted successfully');
    } else {
        header('Location: manage_users.php?error=Error deleting user');
    }
    $stmt->close();
} else {
    header('Location: manage_users.php');
}
?>