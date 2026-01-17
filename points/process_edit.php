<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$id = $_POST['id'];
$siswa_id = $_POST['siswa_id'];
$poin_lama = $_POST['poin_lama']; // Needed to adjust student total

$jenis_pelanggaran = $_POST['jenis_pelanggaran'];
$kategori_pelanggaran = $_POST['kategori_pelanggaran'];
$deskripsi = $_POST['deskripsi'];
$poin_baru = $_POST['poin'];
$tanggal = $_POST['tanggal'];
$tindak_lanjut = $_POST['tindak_lanjut'];
$status = $_POST['status'];
$follow_up_by = $_SESSION['user_id'];
$follow_up_at = date('Y-m-d H:i:s');

$sql = "UPDATE poin_pelanggaran SET 
        jenis_pelanggaran='$jenis_pelanggaran', 
        kategori_pelanggaran='$kategori_pelanggaran', 
        deskripsi='$deskripsi', 
        poin='$poin_baru', 
        tanggal='$tanggal', 
        tindak_lanjut='$tindak_lanjut', 
        status='$status',
        follow_up_by='$follow_up_by',
        follow_up_at='$follow_up_at'
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // Recalculate student total violations
    // Easier and safer to just recalc sum from table
    $conn->query("UPDATE students SET total_poin_pelanggaran = (SELECT SUM(poin) FROM poin_pelanggaran WHERE siswa_id = $siswa_id) WHERE id = $siswa_id");

    logActivity($conn, $_SESSION['user_id'], 'EDIT_VIOLATION', "Updated violation for Student ID $siswa_id");
    header("Location: idx.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>