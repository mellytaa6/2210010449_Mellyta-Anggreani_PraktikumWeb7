<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get info to update Student's total points
    $info = $conn->query("SELECT siswa_id, poin FROM poin_pelanggaran WHERE id = $id")->fetch_assoc();

    $sql = "DELETE FROM poin_pelanggaran WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Deduct points
        $conn->query("UPDATE students SET total_poin_pelanggaran = total_poin_pelanggaran - {$info['poin']} WHERE id = {$info['siswa_id']}");

        logActivity($conn, $_SESSION['user_id'], 'DELETE_VIOLATION', "Deleted violation ID: $id");
        header("Location: idx.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>