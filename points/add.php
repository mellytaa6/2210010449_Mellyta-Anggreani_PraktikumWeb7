<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Fetch Students
$students = $conn->query("SELECT * FROM students WHERE status='aktif' ORDER BY nama_lengkap ASC");
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Lapor Pelanggaran</h1>
    </div>

    <div class="card glass" style="max-width: 800px;">
        <form action="process_add.php" method="POST">

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Pilih Siswa</label>
                <select name="siswa_id" required class="select2">
                    <option value="">-- Cari Siswa --</option>
                    <?php while ($s = $students->fetch_assoc()): ?>
                        <option value="<?= $s['id'] ?>"><?= $s['nama_lengkap'] ?> (<?= $s['nisn'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>

            <h3
                style="margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; color: #ef4444;">
                Detail Pelanggaran</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kategori
                        Pelanggaran</label>
                    <input type="text" name="kategori_pelanggaran" placeholder="Contoh: Terlambat, Merokok, Bolos"
                        required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal</label>
                    <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jenis
                        Pelanggaran</label>
                    <select name="jenis_pelanggaran" required>
                        <option value="ringan">Ringan</option>
                        <option value="sedang">Sedang</option>
                        <option value="berat">Berat</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Poin</label>
                    <input type="number" name="poin" value="5" required>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Deskripsi Detil</label>
                <textarea name="deskripsi" rows="3" required></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Lokasi Kejadian</label>
                    <input type="text" name="lokasi">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Saksi (Jika
                        ada)</label>
                    <input type="text" name="saksi">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Sanksi Awal
                    (Opsional)</label>
                <textarea name="sanksi" rows="2"></textarea>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="background-color: #ef4444;">Lapor</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>