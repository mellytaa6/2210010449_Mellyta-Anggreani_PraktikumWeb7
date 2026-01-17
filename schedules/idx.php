<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$classes = $conn->query("SELECT * FROM classes WHERE status='aktif' ORDER BY nama_kelas ASC");
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';

$schedules = [];
if ($class_id) {
    // Join with jam_pelajaran to get Time
    $where = "WHERE schedules.kelas_id = $class_id AND schedules.status='aktif'";
    $sql = "SELECT schedules.*, 
            classes.nama_kelas, classes.tingkat, classes.kode_kelas,
            subjects.nama_mapel, subjects.kode_mapel,
            users.nama_lengkap as nama_guru,
            jam_pelajaran.jam_mulai, jam_pelajaran.jam_selesai
            FROM schedules 
            JOIN classes ON schedules.kelas_id = classes.id 
            JOIN subjects ON schedules.mapel_id = subjects.id 
            JOIN users ON schedules.guru_id = users.id 
            LEFT JOIN jam_pelajaran ON schedules.sesi = jam_pelajaran.sesi AND (jam_pelajaran.hari = schedules.hari OR jam_pelajaran.hari = 'semua')
            $where 
            ORDER BY FIELD(schedules.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'), schedules.sesi ASC";

    $result = $conn->query($sql);
    if (!$result) {
        die("Query Failed: " . $conn->error . "<br>SQL: " . $sql);
    }
    while ($row = $result->fetch_assoc()) {
        $schedules[$row['hari']][] = $row;
    }
}
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Jadwal Pelajaran</h1>
        <div class="actions">
            <?php if ($class_id): ?>
                <a href="add.php?class_id=<?= $class_id ?>" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Tambah Jadwal
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card glass" style="margin-bottom: 20px;">
        <form method="GET" style="display: flex; gap: 10px; align-items: center;">
            <select name="class_id" onchange="this.form.submit()" style="margin-bottom: 0; max-width: 300px;">
                <option value="">-- Pilih Kelas --</option>
                <?php while ($c = $classes->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>" <?= $class_id == $c['id'] ? 'selected' : '' ?>>
                        <?= $c['nama_kelas'] ?> (<?= $c['tingkat'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </form>
    </div>

    <?php if ($class_id && empty($schedules)): ?>
        <div class="card glass" style="text-align: center; padding: 40px;">
            <i class="fa-regular fa-calendar-xmark"
                style="font-size: 3rem; color: var(--text-muted); margin-bottom: 10px;"></i>
            <p>Belum ada jadwal untuk kelas ini.</p>
        </div>
    <?php endif; ?>

    <div class="schedule-grid">
        <?php foreach ($schedules as $day => $lessons): ?>
            <div class="card glass">
                <h3
                    style="margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; color: var(--accent);">
                    <?= $day ?>
                </h3>
                <?php foreach ($lessons as $lesson): ?>
                    <div
                        style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); position: relative;">
                        <!-- Times -->
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 4px;">
                            <span
                                style="font-weight: bold; background: var(--glass-bg); padding: 2px 6px; border-radius: 4px;">Sesi
                                <?= $lesson['sesi'] ?></span>
                            <?php if ($lesson['jam_mulai']): ?>
                                <i class="fa-regular fa-clock" style="margin-left: 5px;"></i>
                                <?= date('H:i', strtotime($lesson['jam_mulai'])) ?> -
                                <?= date('H:i', strtotime($lesson['jam_selesai'])) ?>
                            <?php endif; ?>
                        </div>

                        <div style="font-weight: bold; font-size: 1.1rem; color: #fff;">
                            <?= $lesson['nama_mapel'] ?>
                        </div>

                        <div style="color: #ccc; font-size: 0.9rem; margin-top: 4px;">
                            <i class="fa-solid fa-user" style="width: 20px;"></i> <?= $lesson['nama_guru'] ?>
                        </div>
                        <div style="color: #ccc; font-size: 0.9rem;">
                            <i class="fa-solid fa-door-open" style="width: 20px;"></i> R. <?= $lesson['ruangan'] ?? '-' ?>
                        </div>

                        <div style="position: absolute; right: 0; top: 0;">
                            <a href="delete.php?id=<?= $lesson['id'] ?>&class_id=<?= $class_id ?>"
                                style="color: #ef4444; font-size: 0.9rem;" onclick="return confirm('Hapus jadwal ini?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
</style>

<?php include '../includes/footer.php'; ?>