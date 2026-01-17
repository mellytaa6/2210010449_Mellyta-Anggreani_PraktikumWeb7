<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

if (!$user_id) {
    echo "<script>window.location.href='../index.php';</script>";
    exit;
}

// Mark all as read if requested
if (isset($_GET['mark_all_read'])) {
    $conn->query("UPDATE notifications SET is_read = 1, read_at = NOW() WHERE user_id = $user_id AND is_read = 0");
    header("Location: idx.php");
    exit;
}

$sql = "SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 50";
$result = $conn->query($sql);
if (!$result) {
    die("Error fetching notifications: " . $conn->error);
}
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Notifikasi Saya</h1>
        <div class="actions">
            <a href="?mark_all_read=1" class="btn" style="background: rgba(255,255,255,0.1);">
                <i class="fa-solid fa-check-double"></i> Tandai Semua Dibaca
            </a>
        </div>
    </div>

    <div class="card glass">
        <?php if ($result->num_rows > 0): ?>
            <ul style="list-style: none; padding: 0;">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li
                        style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 15px; display: flex; gap: 15px; align-items: flex-start; <?= $row['is_read'] ? 'opacity: 0.6;' : 'background: rgba(16, 185, 129, 0.05);' ?>">
                        <div
                            style="flex-shrink: 0; width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            <?php if ($row['type'] == 'success'): ?>
                                <i class="fa-solid fa-check" style="color: #10b981;"></i>
                            <?php elseif ($row['type'] == 'warning'): ?>
                                <i class="fa-solid fa-exclamation" style="color: #f59e0b;"></i>
                            <?php elseif ($row['type'] == 'danger'): ?>
                                <i class="fa-solid fa-triangle-exclamation" style="color: #ef4444;"></i>
                            <?php else: ?>
                                <i class="fa-solid fa-info" style="color: #3b82f6;"></i>
                            <?php endif; ?>
                        </div>
                        <div style="flex-grow: 1;">
                            <div style="display: flex; justify-content: space-between;">
                                <h4 style="margin: 0 0 5px; font-size: 1rem;">
                                    <?= $row['title'] ?>
                                </h4>
                                <small style="color: var(--text-muted);">
                                    <?= date('d M H:i', strtotime($row['created_at'])) ?>
                                </small>
                            </div>
                            <p style="margin: 0; color: #ccc;">
                                <?= $row['message'] ?>
                            </p>
                            <?php if ($row['link'] && $row['link'] != '#'): ?>
                                <a href="<?= $row['link'] ?>"
                                    style="display: inline-block; margin-top: 8px; font-size: 0.85rem; color: var(--accent);">Lihat
                                    Detail &rarr;</a>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada notifikasi.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>