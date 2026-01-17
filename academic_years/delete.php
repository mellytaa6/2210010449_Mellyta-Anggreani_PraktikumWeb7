<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tahun_ajaran WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        logActivity($conn, $_SESSION['user_id'], 'DELETE_ACADEMIC_YEAR', "Deleted year ID: $id");
        header("Location: idx.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>