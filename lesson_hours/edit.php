<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $_GET['id'];
$row = $conn->query("SELECT * FROM jam_pelajaran WHERE id = $id")->fetch_assoc();
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Edit Jam Pelajaran</h1>
    </div>

    <div class="card glass" style="max-width: 600px;">
        <form action="process_edit.php" method="POST">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <h3 style="margin-bottom: 20px;">Detail Sesi</h3>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Berlaku Untuk Hari</label>
                <select name="hari" required>
                    <option value="semua" <?= $row['hari'] == 'semua' ? 'selected' : '' ?>>Semua Hari (Senin-Sabtu)
                    </option>
                    <option value="senin" <?= $row['hari'] == 'senin' ? 'selected' : '' ?>>Senin</option>
                    <option value="selasa" <?= $row['hari'] == 'selasa' ? 'selected' : '' ?>>Selasa</option>
                    <option value="rabu" <?= $row['hari'] == 'rabu' ? 'selected' : '' ?>>Rabu</option>
                    <option value="kamis" <?= $row['hari'] == 'kamis' ? 'selected' : '' ?>>Kamis</option>
                    <option value="jumat" <?= $row['hari'] == 'jumat' ? 'selected' : '' ?>>Jumat</option>
                    <option value="sabtu" <?= $row['hari'] == 'sabtu' ? 'selected' : '' ?>>Sabtu</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Sesi Ke-</label>
                    <input type="number" name="sesi" value="<?= $row['sesi'] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jenis Kegiatan</label>
                    <select name="jenis">
                        <option value="normal" <?= $row['jenis'] == 'normal' ? 'selected' : '' ?>>KBM Normal</option>
                        <option value="istirahat" <?= $row['jenis'] == 'istirahat' ? 'selected' : '' ?>>Istirahat</option>
                        <option value="upacara" <?= $row['jenis'] == 'upacara' ? 'selected' : '' ?>>Upacara</option>
                        <option value="literasi" <?= $row['jenis'] == 'literasi' ? 'selected' : '' ?>>Literasi/Doa</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jam Mulai</label>
                    <input type="time" name="jam_mulai" value="<?= date('H:i', strtotime($row['jam_mulai'])) ?>"
                        required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jam Selesai</label>
                    <input type="time" name="jam_selesai" value="<?= date('H:i', strtotime($row['jam_selesai'])) ?>"
                        required>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Keterangan</label>
                <input type="text" name="keterangan" value="<?= $row['keterangan'] ?>">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status</label>
                <select name="status">
                    <option value="aktif" <?= $row['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="nonaktif" <?= $row['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
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