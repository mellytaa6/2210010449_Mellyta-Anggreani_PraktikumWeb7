<?php
session_start();
if (isset($_SESSION['user_id'])) {
    include 'config/database.php';
    include 'includes/functions.php';
    logActivity($conn, $_SESSION['user_id'], 'LOGOUT', 'User logged out');
}
session_destroy();
header("Location: index.php");
exit;
?>