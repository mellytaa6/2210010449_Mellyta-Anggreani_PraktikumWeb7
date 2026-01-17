<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$jenis = $_POST['jenis'];
$nama_kategori = $_POST['nama_kategori'];
$deskripsi = $_POST['deskripsi'];
$poin_min = $_POST['poin_min'];
$poin_max = $_POST['poin_max'];
$sanksi = $_POST['sanksi'];
$penghargaan = $_POST['penghargaan'];
$status = $_POST['status'];

$sql = "INSERT INTO poin_kategori (jenis, nama_kategori, deskripsi, poin_min, poin_max, sanksi, penghargaan, status) 
        VALUES ('$jenis', '$nama_kategori', '$deskripsi', '$poin_min', '$poin_max', '$sanksi', '$penghargaan', '$status')";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'ADD_CATEGORY', "Added category: $nama_kategori ($jenis)");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>