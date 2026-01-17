<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $_GET['id'];
$row = $conn->query("SELECT * FROM poin_pelanggaran WHERE id = $id")->fetch_assoc();
$student = $conn->query("SELECT * FROM students WHERE id = {$row['siswa_id']}")->fetch_assoc();
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Tindak Lanjut Pelanggaran</h1>
    </div>

    <div class="card glass" style="max-width: 800px;">
        <form action="process_edit.php" method="POST">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="siswa_id" value="<?= $row['siswa_id'] ?>">
            <input type="hidden" name="poin_lama" value="<?= $row['poin'] ?>">

            <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <h4 style="margin-bottom: 10px;">Informasi Siswa</h4>
                <p><strong>Nama:</strong>
                    <?= $student['nama_lengkap'] ?> (
                    <?= $student['nisn'] ?>)
                </p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kategori
                        Pelanggaran</label>
                    <input type="text" name="kategori_pelanggaran" value="<?= $row['kategori_pelanggaran'] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal</label>
                    <input type="date" name="tanggal" value="<?= $row['tanggal'] ?>" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jenis
                        Pelanggaran</label>
                    <select name="jenis_pelanggaran">
                        <option value="ringan" <?= $row['jenis_pelanggaran'] == 'ringan' ? 'selected' : '' ?>>Ringan
                        </option>
                        <option value="sedang" <?= $row['jenis_pelanggaran'] == 'sedang' ? 'selected' : '' ?>>Sedang
                        </option>
                        <option value="berat" <?= $row['jenis_pelanggaran'] == 'berat' ? 'selected' : '' ?>>Berat</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Poin</label>
                    <input type="number" name="poin" value="<?= $row['poin'] ?>" required>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Deskripsi</label>
                <textarea name="deskripsi" rows="3"><?= $row['deskripsi'] ?></textarea>
            </div>

            <h3
                style="margin-bottom: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; color: var(--accent);">
                Tindak Lanjut & Status</h3>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Isi Tindak Lanjut /
                    Hukuman</label>
                <textarea name="tindak_lanjut" rows="3"
                    placeholder="Contoh: Pemanggilan orang tua, Skorsing, dll."><?= $row['tindak_lanjut'] ?></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status Kasus</label>
                <select name="status">
                    <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="ditindak" <?= $row['status'] == 'ditindak' ? 'selected' : '' ?>>Sedang Ditindak</option>
                    <option value="selesai" <?= $row['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>