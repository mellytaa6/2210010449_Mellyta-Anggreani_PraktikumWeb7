<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$id = $_POST['id'];
$siswa_id = $_POST['siswa_id'];
$jenis_prestasi = $_POST['jenis_prestasi'];
$kategori = $_POST['kategori'];
$nama_prestasi = $_POST['nama_prestasi'];
$deskripsi = $_POST['deskripsi'];
$tingkat = $_POST['tingkat'];
$peringkat = $_POST['peringkat'];
$poin = $_POST['poin'];
$tanggal = $_POST['tanggal'];
$penyelenggara = $_POST['penyelenggara'];
$lokasi = $_POST['lokasi'];
$status = $_POST['status'];

$sql = "UPDATE poin_prestasi SET 
        siswa_id='$siswa_id', 
        jenis_prestasi='$jenis_prestasi', 
        kategori='$kategori', 
        nama_prestasi='$nama_prestasi', 
        deskripsi='$deskripsi', 
        tingkat='$tingkat', 
        peringkat='$peringkat', 
        poin='$poin', 
        tanggal='$tanggal', 
        penyelenggara='$penyelenggara', 
        lokasi='$lokasi',
        status='$status'
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // If status is approved, maybe redundant point logic if edited? 
    // For simplicity, we assume generic update. Ideally we'd recalculate total points for safety.
    $conn->query("UPDATE students SET total_poin_prestasi = (SELECT SUM(poin) FROM poin_prestasi WHERE siswa_id = $siswa_id AND status='approved') WHERE id = $siswa_id");

    logActivity($conn, $_SESSION['user_id'], 'EDIT_ACHIEVEMENT', "Updated achievement: $nama_prestasi");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>