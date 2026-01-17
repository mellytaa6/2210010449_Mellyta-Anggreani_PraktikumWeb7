<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

// Prepare variables (Sanitize if needed, usually Prepared Statements handle safety)
$nis = $_POST['nis'];
$nisn = $_POST['nisn'];
$kelas_id = $_POST['kelas_id'] ? $_POST['kelas_id'] : 'NULL';
$tahun_masuk = $_POST['tahun_masuk'];
$status = $_POST['status'];

$nama_lengkap = $_POST['nama_lengkap'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'] ? $_POST['tanggal_lahir'] : 'NULL';
$jenis_kelamin = $_POST['jenis_kelamin'];
$agama = $_POST['agama'];
$no_telepon = $_POST['no_telepon'];
$email = $_POST['email'];

$alamat = $_POST['alamat'];
$rt_rw = $_POST['rt_rw'];
$kelurahan = $_POST['kelurahan'];
$kecamatan = $_POST['kecamatan'];
$kota = $_POST['kota'];
$provinsi = $_POST['provinsi'];
$kode_pos = $_POST['kode_pos'];

$nama_ayah = $_POST['nama_ayah'];
$pekerjaan_ayah = $_POST['pekerjaan_ayah'];
$nama_ibu = $_POST['nama_ibu'];
$pekerjaan_ibu = $_POST['pekerjaan_ibu'];
// Check for duplicates
$check = $conn->query("SELECT id FROM students WHERE nis = '$nis' OR nisn = '$nisn'");
if ($check->num_rows > 0) {
    echo "<script>alert('Error: NIS or NISN already registered!'); window.history.back();</script>";
    exit;
}

// Upload Photo
$foto_name = NULL;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $upload = uploadImage($_FILES['foto']);
    if (isset($upload['success'])) {
        $foto_name = $upload['success'];
    } else {
        die($upload['error']);
    }
}

$foto_sql = $foto_name ? "'$foto_name'" : "NULL";
$tgl_sql = ($tanggal_lahir && $tanggal_lahir != 'NULL') ? "'$tanggal_lahir'" : "NULL";

$sql = "INSERT INTO students (
    nis, nisn, kelas_id, tahun_masuk, status, 
    nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, no_telepon, email,
    alamat, rt_rw, kelurahan, kecamatan, kota, provinsi, kode_pos,
    nama_ayah, pekerjaan_ayah, nama_ibu, pekerjaan_ibu, no_telepon_ortu, foto
) VALUES (
    '$nis', '$nisn', $kelas_id, '$tahun_masuk', '$status',
    '$nama_lengkap', '$tempat_lahir', $tgl_sql, '$jenis_kelamin', '$agama', '$no_telepon', '$email',
    '$alamat', '$rt_rw', '$kelurahan', '$kecamatan', '$kota', '$provinsi', '$kode_pos',
    '$nama_ayah', '$pekerjaan_ayah', '$nama_ibu', '$pekerjaan_ibu', '$no_telepon_ortu', $foto_sql
)";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'ADD_STUDENT', "Added student: $nama_lengkap ($nisn)");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>