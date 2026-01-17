<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$id = $_POST['id'];
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

$sql = "UPDATE classes SET 
        kode_kelas='$kode_kelas', 
        nama_kelas='$nama_kelas', 
        tingkat='$tingkat',
        jurusan='$jurusan', 
        wali_kelas_id=$wali_kelas_id, 
        ruangan='$ruangan',
        kapasitas=$kapasitas,
        tahun_ajaran='$tahun_ajaran',
        semester='$semester',
        status='$status'
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'EDIT_CLASS', "Updated class: $nama_kelas");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>