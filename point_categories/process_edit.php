<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$id = $_POST['id'];
$jenis = $_POST['jenis'];
$nama_kategori = $_POST['nama_kategori'];
$deskripsi = $_POST['deskripsi'];
$poin_min = $_POST['poin_min'];
$poin_max = $_POST['poin_max'];
$sanksi = $_POST['sanksi'];
$penghargaan = $_POST['penghargaan'];
$status = $_POST['status'];

$sql = "UPDATE poin_kategori SET 
        jenis='$jenis', 
        nama_kategori='$nama_kategori', 
        deskripsi='$deskripsi', 
        poin_min='$poin_min', 
        poin_max='$poin_max', 
        sanksi='$sanksi', 
        penghargaan='$penghargaan', 
        status='$status' 
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'EDIT_CATEGORY', "Edited category: $nama_kategori");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>