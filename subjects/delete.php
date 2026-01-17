<?php
include '../config/database.php';
$id = $_GET['id'];
$conn->query("DELETE FROM subjects WHERE id = $id");
header("Location: idx.php");
?>