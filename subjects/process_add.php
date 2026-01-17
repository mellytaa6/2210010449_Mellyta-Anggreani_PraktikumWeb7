<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

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
$tahun_ajaran = date('Y') . '/' . (date('Y') + 1); // Default logic

$sql = "INSERT INTO subjects (kode_mapel, nama_mapel, kategori, tingkat, jurusan, guru_id, kelas_id, semester, tahun_ajaran, jam_per_minggu, deskripsi, status) 
        VALUES ('$kode_mapel', '$nama_mapel', '$kategori', '$tingkat', '$jurusan', $guru_id, $kelas_id, '$semester', '$tahun_ajaran', '$jam_per_minggu', '$deskripsi', '$status')";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'ADD_SUBJECT', "Added subject: $nama_mapel ($kode_mapel)");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>