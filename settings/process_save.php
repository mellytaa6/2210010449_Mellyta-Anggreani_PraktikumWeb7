<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $settings = $_POST['settings'];

    // Handle File Uploads first
    foreach ($_FILES as $key => $file) {
        if ($file['error'] == 0 && strpos($key, 'file_') === 0) {
            $id = str_replace('file_', '', $key);

            // Generate unique filename
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'assets/img/settings_' . $id . '_' . time() . '.' . $ext;
            $target = '../' . $filename;

            if (move_uploaded_file($file['tmp_name'], $target)) {
                $settings[$id] = $filename; // Update value to new path
            }
        }
    }

    // Update DB
    foreach ($settings as $id => $value) {
        $value = $conn->real_escape_string($value);
        $conn->query("UPDATE settings SET setting_value = '$value' WHERE id = $id");
    }

    logActivity($conn, $_SESSION['user_id'], 'UPDATE_SETTINGS', "Updated system configuration");
    header("Location: idx.php?status=success");
}
?>