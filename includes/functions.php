<?php
function logActivity($conn, $user_id, $action, $description, $module = null, $details = null)
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $referrer = $_SERVER['HTTP_REFERER'] ?? '';

    // Map old 'action' to 'activity' if needed, or just strict usage
    $activity = $description;

    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, activity, module, action, details, ip_address, user_agent, referrer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $user_id, $activity, $module, $action, $details, $ip, $user_agent, $referrer);
    $stmt->execute();
}

function createNotification($conn, $user_id, $title, $message, $type = 'info', $link = '#', $data = [])
{
    $json_data = json_encode($data);
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, title, message, type, link, data) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $title, $message, $type, $link, $json_data);
    $stmt->execute();
}

function uploadImage($file, $target_dir = "../assets/uploads/")
{
    if ($file['error'] != 0)
        return null;

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024; // 2MB

    // Validate Type
    if (!in_array($file['type'], $allowed_types)) {
        return ['error' => 'Format file tidak valid (JPG/PNG only)'];
    }

    // Validate Size
    if ($file['size'] > $max_size) {
        return ['error' => 'Ukuran file terlalu besar (Max 2MB)'];
    }

    // Generate Secure Name
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_name = uniqid('img_', true) . '.' . $ext;

    // Check if directory exists, if not create
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $target_dir . $new_name)) {
        return ['success' => $new_name];
    }

    return ['error' => 'Gagal mengupload file'];
}
?>