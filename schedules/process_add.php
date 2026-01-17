<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$kelas_id = $_POST['kelas_id'];
$hari = $_POST['hari'];
$sesi = $_POST['sesi'];
$mapel_id = $_POST['mapel_id'];
$guru_id = $_POST['guru_id'];
$ruangan = $_POST['ruangan'];
$semester = $_POST['semester'];
$tahun_ajaran = $_POST['tahun_ajaran'];
$status = 'aktif';

$sql = "INSERT INTO schedules (kelas_id, mapel_id, guru_id, hari, sesi, ruangan, tahun_ajaran, semester, status) 
        VALUES ($kelas_id, $mapel_id, $guru_id, '$hari', $sesi, '$ruangan', '$tahun_ajaran', '$semester', '$status')";

if ($conn->query($sql) === TRUE) {
    logActivity($conn, $_SESSION['user_id'], 'ADD_SCHEDULE', "Added schedule: Class $kelas_id, Day $hari, Session $sesi");
    header("Location: idx.php?class_id=$kelas_id");
} else {
    // Unique constraint error usually
    if ($conn->errno == 1062) {
        echo "<script>alert('Jadwal bentrok! Sesi ini sudah terisi untuk kelas tersebut pada tahun ajaran/semester yang sama.'); window.history.back();</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>