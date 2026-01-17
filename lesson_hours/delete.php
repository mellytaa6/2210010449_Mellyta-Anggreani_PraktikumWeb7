<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Log before delete (optional, or gets deleted too quick)
    logActivity($conn, $_SESSION['user_id'], 'DELETE_SESSION', "Deleted session ID: $id");

    $sql = "DELETE FROM jam_pelajaran WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: idx.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>