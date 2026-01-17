<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Fetch Settings
$settings = [];
$result = $conn->query("SELECT * FROM settings ORDER BY setting_group ASC, id ASC");
while ($row = $result->fetch_assoc()) {
    $settings[$row['setting_group']][] = $row;
}
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Pengaturan Sistem</h1>
    </div>

    <form action="process_save.php" method="POST" enctype="multipart/form-data">
        <?php foreach ($settings as $group => $items): ?>
            <div class="card glass" style="max-width: 800px; margin-bottom: 25px;">
                <h3
                    style="text-transform: capitalize; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px; color: var(--accent);">
                    <?= $group ?> Settings
                </h3>

                <?php foreach ($items as $item): ?>
                    <div style="margin-bottom: 20px;">
                        <label style="color: var(--text-muted); display: block; margin-bottom: 8px; font-weight: bold;">
                            <?= $item['label'] ?>
                        </label>

                        <?php if ($item['setting_type'] == 'text'): ?>
                            <input type="text" name="settings[<?= $item['id'] ?>]"
                                value="<?= htmlspecialchars($item['setting_value']) ?>"
                                style="width: 100%; padding: 10px; border-radius: 5px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: #fff;">

                        <?php elseif ($item['setting_type'] == 'number'): ?>
                            <input type="number" name="settings[<?= $item['id'] ?>]"
                                value="<?= htmlspecialchars($item['setting_value']) ?>"
                                style="width: 100%; padding: 10px; border-radius: 5px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: #fff;">

                        <?php elseif ($item['setting_type'] == 'boolean'): ?>
                            <select name="settings[<?= $item['id'] ?>]"
                                style="width: 100%; padding: 10px; border-radius: 5px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: #fff;">
                                <option value="1" <?= $item['setting_value'] == '1' ? 'selected' : '' ?>>Ya / Aktif</option>
                                <option value="0" <?= $item['setting_value'] == '0' ? 'selected' : '' ?>>Tidak / Nonaktif</option>
                            </select>

                        <?php elseif ($item['setting_type'] == 'image'): ?>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <?php if ($item['setting_value']): ?>
                                    <img src="../<?= $item['setting_value'] ?>" alt="Preview" style="height: 50px; border-radius: 4px;">
                                <?php endif; ?>
                                <input type="file" name="file_<?= $item['id'] ?>" accept="image/*"
                                    style="color: var(--text-muted);">
                                <input type="hidden" name="settings[<?= $item['id'] ?>]" value="<?= $item['setting_value'] ?>">
                            </div>
                        <?php endif; ?>

                        <small style="display: block; margin-top: 5px; color: rgba(255,255,255,0.4); font-size: 0.8rem;">
                            <?= $item['description'] ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <div style="margin-bottom: 50px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem;">
                <i class="fa-solid fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>