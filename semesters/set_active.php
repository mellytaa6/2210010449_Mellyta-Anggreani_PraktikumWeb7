<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Deactivate currently active
    $conn->query("UPDATE semester SET status='selesai' WHERE status='aktif'");

    // Activate new one
    $sql = "UPDATE semester SET status='aktif' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        logActivity($conn, $_SESSION['user_id'], 'ACTIVATE_SEMESTER', "Activated semester ID: $id");
        header("Location: idx.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>