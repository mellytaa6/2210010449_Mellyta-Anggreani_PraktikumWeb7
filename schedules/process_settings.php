<?php
include '../config/database.php';

foreach ($_POST as $key => $value) {
    // Simple update or insert on duplicate key if structured differently, 
    // but here we know keys exist or we assume they do.
    // For safer implementation, let's use UPDATE.
    $key = $conn->real_escape_string($key);
    $value = $conn->real_escape_string($value);

    // Check if exists
    $check = $conn->query("SELECT * FROM schedule_settings WHERE setting_key = '$key'");
    if ($check->num_rows > 0) {
        $conn->query("UPDATE schedule_settings SET setting_value='$value' WHERE setting_key='$key'");
    } else {
        $conn->query("INSERT INTO schedule_settings (setting_key, setting_value) VALUES ('$key', '$value')");
    }
}

header("Location: settings.php?msg=saved");
?>