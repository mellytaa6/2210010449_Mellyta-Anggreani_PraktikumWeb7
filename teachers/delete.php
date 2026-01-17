<?php
include '../config/database.php';
$id = $_GET['id'];
// Prevent deleting self? or admin? Logic handled in view, but extra safety good.
$conn->query("DELETE FROM users WHERE id = $id");
header("Location: idx.php");
?>