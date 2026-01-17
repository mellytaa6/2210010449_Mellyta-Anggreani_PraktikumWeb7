<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$id = $_POST['id'];
$hari = $_POST['hari'];
$sesi = $_POST['sesi'];
$jenis = $_POST['jenis'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];
$keterangan = $_POST['keterangan'];
$status = $_POST['status'];

$sql = "UPDATE jam_pelajaran SET 
        hari='$hari', 
        sesi='$sesi', 
        jenis='$jenis', 
        jam_mulai='$jam_mulai', 
        jam_selesai='$jam_selesai', 
        keterangan='$keterangan', 
        status='$status' 
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'EDIT_SESSION', "Updated session: Sesi $sesi ($hari)");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>