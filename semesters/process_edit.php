<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$id = $_POST['id'];
$tahun_ajaran = $_POST['tahun_ajaran'];
$semester = $_POST['semester'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$status = $_POST['status'];

// If setting this to active, deactivate others
if ($status == 'aktif') {
    // Only deactivate others, don't change this one yet
    $conn->query("UPDATE semester SET status='selesai' WHERE status='aktif' AND id != $id");
}

$sql = "UPDATE semester SET 
        tahun_ajaran='$tahun_ajaran', 
        semester='$semester', 
        tanggal_mulai='$tanggal_mulai', 
        tanggal_selesai='$tanggal_selesai', 
        status='$status' 
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'EDIT_SEMESTER', "Edited semester: $tahun_ajaran $semester");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>