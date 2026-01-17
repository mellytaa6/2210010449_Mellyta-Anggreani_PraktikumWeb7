<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

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
$created_by = $_SESSION['user_id'];
$status = 'pending'; // Default status

// Handle File Upload
$upload_dir = '../uploads/achievements/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$foto_path = NULL;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    if ($_FILES['foto']['size'] > 5000000) { // 5MB Limit
        die("File too large");
    }
    // Rename
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $filename = 'prestasi_' . time() . '_' . uniqid() . '.' . $ext;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_dir . $filename)) {
        $foto_path = 'uploads/achievements/' . $filename;
    }
}

$sql = "INSERT INTO poin_prestasi (siswa_id, jenis_prestasi, kategori, nama_prestasi, deskripsi, tingkat, peringkat, poin, tanggal, penyelenggara, lokasi, foto, created_by, status) 
        VALUES ('$siswa_id', '$jenis_prestasi', '$kategori', '$nama_prestasi', '$deskripsi', '$tingkat', '$peringkat', '$poin', '$tanggal', '$penyelenggara', '$lokasi', '$foto_path', '$created_by', '$status')";

if ($conn->query($sql) === TRUE) {
    // Also update total points in students table
    $conn->query("UPDATE students SET total_poin_prestasi = total_poin_prestasi + $poin WHERE id = $siswa_id");

    // Log to aktivitas_siswa
    $desc = "Prestasi: $nama_prestasi ($tingkat - $peringkat)";
    $waktu = date('H:i:s');
    $last_id = $conn->insert_id;
    $conn->query("INSERT INTO aktivitas_siswa (siswa_id, jenis_aktivitas, deskripsi, tanggal, waktu, created_by, referensi_id, referensi_tabel) 
                  VALUES ('$siswa_id', 'prestasi', '$desc', '$tanggal', '$waktu', '$created_by', '$last_id', 'poin_prestasi')");

    logActivity($conn, $_SESSION['user_id'], 'ADD_ACHIEVEMENT', "Added achievement for Student ID $siswa_id");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>