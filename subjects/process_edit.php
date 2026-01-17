<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$id = $_POST['id'];
$kode_mapel = $_POST['kode_mapel'];
$nama_mapel = $_POST['nama_mapel'];
$kategori = $_POST['kategori'];
$tingkat = $_POST['tingkat'];
$jurusan = $_POST['jurusan'];
$guru_id = $_POST['guru_id'] ? $_POST['guru_id'] : 'NULL';
$kelas_id = $_POST['kelas_id'] ? $_POST['kelas_id'] : 'NULL';
$semester = $_POST['semester'];
$jam_per_minggu = $_POST['jam_per_minggu'];
$deskripsi = $_POST['deskripsi'];
$status = $_POST['status'];

$sql = "UPDATE subjects SET 
        kode_mapel='$kode_mapel', 
        nama_mapel='$nama_mapel',
        kategori='$kategori',
        tingkat='$tingkat',
        jurusan='$jurusan', 
        guru_id=$guru_id, 
        kelas_id=$kelas_id,
        semester='$semester',
        jam_per_minggu='$jam_per_minggu',
        deskripsi='$deskripsi',
        status='$status'
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'EDIT_SUBJECT', "Updated subject: $nama_mapel");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>