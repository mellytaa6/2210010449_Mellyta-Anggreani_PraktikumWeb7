<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$id = $_POST['id'];
$username = $_POST['username'];
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

// Handle Password
$sql_pass = "";
if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql_pass = ", password='$password'";
}

// Handle Photo
$sql_foto = "";
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $res = uploadImage($_FILES['foto']);
    if (isset($res['success'])) {
        $foto = $res['success'];
        $sql_foto = ", foto='$foto'";
    }
}

$tgl_sql = ($tanggal_lahir && $tanggal_lahir != 'NULL') ? "'$tanggal_lahir'" : "NULL";

$sql = "UPDATE users SET 
        username='$username', 
        nama_lengkap='$nama_lengkap', 
        role='$role', 
        status='$status',
        nip='$nip',
        jenis_kelamin='$jenis_kelamin',
        tempat_lahir='$tempat_lahir',
        tanggal_lahir=$tgl_sql,
        alamat='$alamat',
        no_telepon='$no_telepon',
        email='$email',
        jabatan='$jabatan',
        bidang_studi='$bidang_studi'
        $sql_pass
        $sql_foto
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'EDIT_USER', "Updated user: $nama_lengkap");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>