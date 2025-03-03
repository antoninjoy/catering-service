<?php
// Start the session (if not already started)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destroy the session
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session

// Redirect to the index page
header("Location: index.php");
exit;
?>