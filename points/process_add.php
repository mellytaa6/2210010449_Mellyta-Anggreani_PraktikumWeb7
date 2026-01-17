<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$siswa_id = $_POST['siswa_id'];
$jenis_pelanggaran = $_POST['jenis_pelanggaran'];
$kategori_pelanggaran = $_POST['kategori_pelanggaran'];
$deskripsi = $_POST['deskripsi'];
$poin = $_POST['poin'];
$tanggal = $_POST['tanggal'];
$sanksi = $_POST['sanksi'];
$lokasi = $_POST['lokasi'];
$saksi = $_POST['saksi'];
$ditindak_oleh = $_SESSION['user_id'];
$status = 'pending';

$sql = "INSERT INTO poin_pelanggaran (siswa_id, jenis_pelanggaran, kategori_pelanggaran, deskripsi, poin, tanggal, sanksi, lokasi, saksi, ditindak_oleh, status) 
        VALUES ('$siswa_id', '$jenis_pelanggaran', '$kategori_pelanggaran', '$deskripsi', '$poin', '$tanggal', '$sanksi', '$lokasi', '$saksi', '$ditindak_oleh', '$status')";

if ($conn->query($sql) === TRUE) {
    // Increment student violation points
    $conn->query("UPDATE students SET total_poin_pelanggaran = total_poin_pelanggaran + $poin WHERE id = $siswa_id");

    // Log to aktivitas_siswa
    $desc = "Pelanggaran: $kategori_pelanggaran ($jenis_pelanggaran) - Poin: $poin";
    $waktu = date('H:i:s');
    $last_id = $conn->insert_id;
    $conn->query("INSERT INTO aktivitas_siswa (siswa_id, jenis_aktivitas, deskripsi, tanggal, waktu, created_by, referensi_id, referensi_tabel) 
                  VALUES ('$siswa_id', 'pelanggaran', '$desc', '$tanggal', '$waktu', '$ditindak_oleh', '$last_id', 'poin_pelanggaran')");

    logActivity($conn, $_SESSION['user_id'], 'ADD_VIOLATION', "Reported violation for Student ID $siswa_id: $kategori_pelanggaran");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>