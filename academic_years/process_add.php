<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$tahun_ajaran = $_POST['tahun_ajaran'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$status = $_POST['status'];

// If setting this to active, deactivate others
if ($status == 'aktif') {
    $conn->query("UPDATE tahun_ajaran SET status='selesai' WHERE status='aktif'");
}

$sql = "INSERT INTO tahun_ajaran (tahun_ajaran, tanggal_mulai, tanggal_selesai, status) 
        VALUES ('$tahun_ajaran', '$tanggal_mulai', '$tanggal_selesai', '$status')";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'ADD_ACADEMIC_YEAR', "Added year: $tahun_ajaran");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>