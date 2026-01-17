<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';

    $sql = "DELETE FROM schedules WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        logActivity($conn, $_SESSION['user_id'], 'DELETE_SCHEDULE', "Deleted schedule ID: $id");
        header("Location: idx.php?class_id=$class_id");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>