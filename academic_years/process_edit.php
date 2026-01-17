<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$id = $_POST['id'];
$tahun_ajaran = $_POST['tahun_ajaran'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$status = $_POST['status'];

// If setting this to active, deactivate others
if ($status == 'aktif') {
    $conn->query("UPDATE tahun_ajaran SET status='selesai' WHERE status='aktif' AND id != $id");
}

$sql = "UPDATE tahun_ajaran SET 
        tahun_ajaran='$tahun_ajaran', 
        tanggal_mulai='$tanggal_mulai', 
        tanggal_selesai='$tanggal_selesai', 
        status='$status' 
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'EDIT_ACADEMIC_YEAR', "Edited year: $tahun_ajaran");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>