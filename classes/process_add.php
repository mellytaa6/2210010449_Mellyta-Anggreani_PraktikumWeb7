<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$kode_kelas = $_POST['kode_kelas'];
$nama_kelas = $_POST['nama_kelas'];
$tingkat = $_POST['tingkat'];
$jurusan = $_POST['jurusan'];
$wali_kelas_id = $_POST['wali_kelas_id'] ? $_POST['wali_kelas_id'] : 'NULL';
$ruangan = $_POST['ruangan'];
$kapasitas = $_POST['kapasitas'];
$tahun_ajaran = $_POST['tahun_ajaran'];
$semester = $_POST['semester'];
$status = $_POST['status'];

$sql = "INSERT INTO classes (kode_kelas, nama_kelas, tingkat, jurusan, wali_kelas_id, ruangan, kapasitas, tahun_ajaran, semester, status) 
        VALUES ('$kode_kelas', '$nama_kelas', '$tingkat', '$jurusan', $wali_kelas_id, '$ruangan', $kapasitas, '$tahun_ajaran', '$semester', '$status')";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'ADD_CLASS', "Added class: $nama_kelas ($kode_kelas)");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>