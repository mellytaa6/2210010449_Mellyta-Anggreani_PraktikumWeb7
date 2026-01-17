<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $_GET['id'];
$class = $conn->query("SELECT * FROM classes WHERE id = $id")->fetch_assoc();
$teachers = $conn->query("SELECT * FROM users WHERE role='guru' ORDER BY nama_lengkap ASC");
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Edit Kelas</h1>
    </div>

    <div class="card glass" style="max-width: 800px;">
        <form action="process_edit.php" method="POST">
            <input type="hidden" name="id" value="<?= $class['id'] ?>">

            <h3 style="margin-bottom: 20px;">Informasi Kelas</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kode Kelas</label>
                    <input type="text" name="kode_kelas" value="<?= $class['kode_kelas'] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Kelas</label>
                    <input type="text" name="nama_kelas" value="<?= $class['nama_kelas'] ?>" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tingkat</label>
                    <select name="tingkat" required>
                        <option value="X" <?= $class['tingkat'] == 'X' ? 'selected' : '' ?>>X</option>
                        <option value="XI" <?= $class['tingkat'] == 'XI' ? 'selected' : '' ?>>XI</option>
                        <option value="XII" <?= $class['tingkat'] == 'XII' ? 'selected' : '' ?>>XII</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jurusan</label>
                    <input type="text" name="jurusan" value="<?= $class['jurusan'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Ruangan</label>
                    <input type="text" name="ruangan" value="<?= $class['ruangan'] ?>">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Wali Kelas</label>
                    <select name="wali_kelas_id">
                        <option value="">Pilih Wali Kelas</option>
                        <?php while ($t = $teachers->fetch_assoc()): ?>
                            <option value="<?= $t['id'] ?>" <?= $class['wali_kelas_id'] == $t['id'] ? 'selected' : '' ?>>
                                <?= $t['nama_lengkap'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kapasitas</label>
                    <input type="number" name="kapasitas" value="<?= $class['kapasitas'] ?>">
                </div>
            </div>

            <h3 style="margin-top: 20px; margin-bottom: 20px;">Tahun Ajaran & Status</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" value="<?= $class['tahun_ajaran'] ?>"
                        placeholder="2024/2025">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Semester</label>
                    <select name="semester">
                        <option value="ganjil" <?= $class['semester'] == 'ganjil' ? 'selected' : '' ?>>Ganjil</option>
                        <option value="genap" <?= $class['semester'] == 'genap' ? 'selected' : '' ?>>Genap</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status</label>
                    <select name="status">
                        <option value="aktif" <?= $class['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= $class['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>