<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$tahun_ajaran = $_POST['tahun_ajaran'];
$semester = $_POST['semester'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$status = $_POST['status'];

// If setting this to active, deactivate others
if ($status == 'aktif') {
    $conn->query("UPDATE semester SET status='selesai' WHERE status='aktif'");
}

$sql = "INSERT INTO semester (tahun_ajaran, semester, tanggal_mulai, tanggal_selesai, status) 
        VALUES ('$tahun_ajaran', '$semester', '$tanggal_mulai', '$tanggal_selesai', '$status')";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'ADD_SEMESTER', "Added semester: $tahun_ajaran $semester");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>