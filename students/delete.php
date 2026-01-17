<?php
include '../config/database.php';
$id = $_GET['id'];
// Optional: Delete photo file
$student = $conn->query("SELECT photo FROM students WHERE id = $id")->fetch_assoc();
if ($student['photo']) {
    unlink("../assets/uploads/" . $student['photo']);
}
$conn->query("DELETE FROM students WHERE id = $id");
header("Location: idx.php");
?>