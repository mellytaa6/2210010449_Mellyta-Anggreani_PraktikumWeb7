<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$hari = $_POST['hari'];
$sesi = $_POST['sesi'];
$jenis = $_POST['jenis'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];
$keterangan = $_POST['keterangan'];
$status = $_POST['status'];

$sql = "INSERT INTO jam_pelajaran (hari, sesi, jenis, jam_mulai, jam_selesai, keterangan, status) 
        VALUES ('$hari', '$sesi', '$jenis', '$jam_mulai', '$jam_selesai', '$keterangan', '$status')";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'ADD_SESSION', "Added session: Sesi $sesi ($hari)");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>