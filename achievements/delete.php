<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get info to update Student's total points before deleting
    $info = $conn->query("SELECT siswa_id, poin, status FROM poin_prestasi WHERE id = $id")->fetch_assoc();

    $sql = "DELETE FROM poin_prestasi WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        if ($info['status'] == 'approved') {
            // Deduct points
            $conn->query("UPDATE students SET total_poin_prestasi = total_poin_prestasi - {$info['poin']} WHERE id = {$info['siswa_id']}");
        }

        logActivity($conn, $_SESSION['user_id'], 'DELETE_ACHIEVEMENT', "Deleted achievement ID: $id");
        header("Location: idx.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>