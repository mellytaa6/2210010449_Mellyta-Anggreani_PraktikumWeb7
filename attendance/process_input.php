<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];
    $date = $_POST['date'];
    $session = $_POST['session'];
    $statuses = $_POST['status']; // Array [student_id => status]
    $notes = $_POST['keterangan']; // Array [student_id => note]
    $teacher_id = $_SESSION['user_id'];
    $method = 'manual';

    $count = 0;
    foreach ($statuses as $student_id => $status) {
        $note = isset($notes[$student_id]) ? $notes[$student_id] : '';

        // Use Insert On Duplicate Key Update to handle re-submission
        $sql = "INSERT INTO absensi (siswa_id, mapel_id, tanggal, sesi, status, keterangan, guru_id, metode_absen) 
                VALUES ('$student_id', '$subject_id', '$date', '$session', '$status', '$note', '$teacher_id', '$method')
                ON DUPLICATE KEY UPDATE 
                status = '$status', 
                keterangan = '$note',
                guru_id = '$teacher_id',
                updated_at = CURRENT_TIMESTAMP";

        if ($conn->query($sql)) {
            $count++;
            // Log to aktivitas_siswa after successful update/insert
            if ($status != 'alfa') { // Only log meaningful activities or all? Let's log all for history
                $desc = "Absensi: " . ucfirst($status) . " (Sesi $session) - " . ($note ? $note : 'Tanpa Keterangan');
                $waktu = date('H:i:s');
                $conn->query("INSERT INTO aktivitas_siswa (siswa_id, jenis_aktivitas, deskripsi, tanggal, waktu, created_by, referensi_id, referensi_tabel) 
                              VALUES ('$student_id', 'absensi', '$desc', '$date', '$waktu', '{$_SESSION['user_id']}', '0', 'absensi')");
            }
        } else {
            // Silently fail or log error? For now, proceed.
            // echo "Error: " . $conn->error;
        }
    }

    logActivity($conn, $_SESSION['user_id'], 'INPUT_ATTENDANCE', "Input attendance for Class $class_id, Date $date, Session $session ($count students)");

    // Redirect to List or back to Input with success
    header("Location: idx.php?msg=success");
}
?>