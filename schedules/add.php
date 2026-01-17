<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$class_id_selected = isset($_GET['class_id']) ? $_GET['class_id'] : '';

// Get Data for Dropdowns
$classes = $conn->query("SELECT * FROM classes WHERE status='aktif' ORDER BY tingkat ASC, nama_kelas ASC");
$subjects = $conn->query("SELECT * FROM subjects WHERE status='aktif' ORDER BY nama_mapel ASC");
$teachers = $conn->query("SELECT * FROM users WHERE role='guru' ORDER BY nama_lengkap ASC");
// Distinct Sessions from jam_pelajaran
$sessions = $conn->query("SELECT DISTINCT sesi FROM jam_pelajaran WHERE status='aktif' AND jenis='normal' ORDER BY sesi ASC");
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Tambah Jadwal</h1>
    </div>

    <div class="card glass" style="max-width: 600px;">
        <form action="process_add.php" method="POST">

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kelas</label>
                <select name="kelas_id" required>
                    <option value="">Pilih Kelas</option>
                    <?php while ($c = $classes->fetch_assoc()): ?>
                        <option value="<?= $c['id'] ?>" <?= $class_id_selected == $c['id'] ? 'selected' : '' ?>>
                            <?= $c['nama_kelas'] ?> (<?= $c['kode_kelas'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Hari</label>
                    <select name="hari" required>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Sesi Ke-</label>
                    <select name="sesi" required>
                        <option value="">Pilih Sesi</option>
                        <?php
                        if ($sessions->num_rows > 0) {
                            while ($s = $sessions->fetch_assoc()):
                                ?>
                                <option value="<?= $s['sesi'] ?>">Sesi <?= $s['sesi'] ?></option>
                            <?php
                            endwhile;
                        } else {
                            // Fallback if no sessions configured
                            for ($i = 1; $i <= 10; $i++)
                                echo "<option value='$i'>Sesi $i</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Mata Pelajaran</label>
                <select name="mapel_id" required>
                    <option value="">Pilih Mapel</option>
                    <?php while ($s = $subjects->fetch_assoc()): ?>
                        <option value="<?= $s['id'] ?>"><?= $s['nama_mapel'] ?> (<?= $s['kode_mapel'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Guru Pengampu</label>
                <select name="guru_id" required>
                    <option value="">Pilih Guru</option>
                    <?php while ($t = $teachers->fetch_assoc()): ?>
                        <option value="<?= $t['id'] ?>"><?= $t['nama_lengkap'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Ruangan</label>
                    <input type="text" name="ruangan" placeholder="R.01">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Semester</label>
                    <select name="semester">
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" value="<?= date('Y') . '/' . (date('Y') + 1) ?>">
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>