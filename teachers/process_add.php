<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$nama_lengkap = $_POST['nama_lengkap'];
$role = $_POST['role'];
$status = $_POST['status'];
$nip = $_POST['nip'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'] ? $_POST['tanggal_lahir'] : 'NULL';
$alamat = $_POST['alamat'];
$no_telepon = $_POST['no_telepon'];
$email = $_POST['email'];
$jabatan = $_POST['jabatan'];
$bidang_studi = $_POST['bidang_studi'];

// Handle Photo
$foto = NULL;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $res = uploadImage($_FILES['foto']);
    if (isset($res['success']))
        $foto = $res['success'];
}
$foto_sql = $foto ? "'$foto'" : "NULL";
$tgl_sql = ($tanggal_lahir && $tanggal_lahir != 'NULL') ? "'$tanggal_lahir'" : "NULL";

$sql = "INSERT INTO users (username, password, nama_lengkap, role, status, nip, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, no_telepon, email, jabatan, bidang_studi, foto) 
        VALUES ('$username', '$password', '$nama_lengkap', '$role', '$status', '$nip', '$jenis_kelamin', '$tempat_lahir', $tgl_sql, '$alamat', '$no_telepon', '$email', '$jabatan', '$bidang_studi', $foto_sql)";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'ADD_USER', "Added user: $nama_lengkap ($role)");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>