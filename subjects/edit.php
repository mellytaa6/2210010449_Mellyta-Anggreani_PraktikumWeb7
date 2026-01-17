<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $_GET['id'];
$subject = $conn->query("SELECT * FROM subjects WHERE id = $id")->fetch_assoc();
$teachers = $conn->query("SELECT * FROM users WHERE role='guru' ORDER BY nama_lengkap ASC");
$classes = $conn->query("SELECT * FROM classes WHERE status='aktif' ORDER BY nama_kelas ASC");
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Edit Mata Pelajaran</h1>
    </div>

    <div class="card glass" style="max-width: 800px;">
        <form action="process_edit.php" method="POST">
            <input type="hidden" name="id" value="<?= $subject['id'] ?>">

            <h3 style="margin-bottom: 20px;">Informasi Mata Pelajaran</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kode Mapel</label>
                    <input type="text" name="kode_mapel" value="<?= $subject['kode_mapel'] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Mata
                        Pelajaran</label>
                    <input type="text" name="nama_mapel" value="<?= $subject['nama_mapel'] ?>" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tingkat</label>
                    <select name="tingkat" required>
                        <option value="semua" <?= $subject['tingkat'] == 'semua' ? 'selected' : '' ?>>Semua</option>
                        <option value="X" <?= $subject['tingkat'] == 'X' ? 'selected' : '' ?>>X</option>
                        <option value="XI" <?= $subject['tingkat'] == 'XI' ? 'selected' : '' ?>>XI</option>
                        <option value="XII" <?= $subject['tingkat'] == 'XII' ? 'selected' : '' ?>>XII</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kategori</label>
                    <select name="kategori" required>
                        <option value="umum" <?= $subject['kategori'] == 'umum' ? 'selected' : '' ?>>Umum</option>
                        <option value="jurusan" <?= $subject['kategori'] == 'jurusan' ? 'selected' : '' ?>>Jurusan</option>
                        <option value="pilihan" <?= $subject['kategori'] == 'pilihan' ? 'selected' : '' ?>>Pilihan</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jurusan
                        (Opsional)</label>
                    <input type="text" name="jurusan" value="<?= $subject['jurusan'] ?>">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Guru Pengampu</label>
                    <select name="guru_id">
                        <option value="">Pilih Guru</option>
                        <?php while ($t = $teachers->fetch_assoc()): ?>
                            <option value="<?= $t['id'] ?>" <?= $subject['guru_id'] == $t['id'] ? 'selected' : '' ?>>
                                <?= $t['nama_lengkap'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kelas Khusus
                        (Opsional)</label>
                    <select name="kelas_id">
                        <option value="">- Tidak Ada -</option>
                        <?php while ($c = $classes->fetch_assoc()): ?>
                            <option value="<?= $c['id'] ?>" <?= $subject['kelas_id'] == $c['id'] ? 'selected' : '' ?>>
                                <?= $c['nama_kelas'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Semester</label>
                    <select name="semester">
                        <option value="tahunan" <?= $subject['semester'] == 'tahunan' ? 'selected' : '' ?>>Tahunan</option>
                        <option value="ganjil" <?= $subject['semester'] == 'ganjil' ? 'selected' : '' ?>>Ganjil</option>
                        <option value="genap" <?= $subject['semester'] == 'genap' ? 'selected' : '' ?>>Genap</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jam / Minggu</label>
                    <input type="number" name="jam_per_minggu" value="<?= $subject['jam_per_minggu'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status</label>
                    <select name="status">
                        <option value="aktif" <?= $subject['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= $subject['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif
                        </option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Deskripsi</label>
                <textarea name="deskripsi" rows="3"><?= $subject['deskripsi'] ?></textarea>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>