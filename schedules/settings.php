<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Fetch current settings
$settings = [];
$res = $conn->query("SELECT * FROM schedule_settings");
while ($row = $res->fetch_assoc()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Pengaturan Jam Pelajaran</h1>
    </div>

    <div class="card glass" style="max-width: 600px;">
        <form action="process_settings.php" method="POST">
            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jam Masuk Sekolah</label>
                <input type="time" name="school_start_time" value="<?= $settings['school_start_time'] ?? '07:00' ?>"
                    required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jam Pulang Sekolah</label>
                <input type="time" name="school_end_time" value="<?= $settings['school_end_time'] ?? '15:00' ?>"
                    required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Durasi Per Sesi
                    (Menit)</label>
                <input type="number" name="lesson_duration_minutes"
                    value="<?= $settings['lesson_duration_minutes'] ?? '45' ?>" required>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>