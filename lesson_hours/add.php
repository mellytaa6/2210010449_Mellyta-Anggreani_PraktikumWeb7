<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Tambah Jam Pelajaran</h1>
    </div>

    <div class="card glass" style="max-width: 600px;">
        <form action="process_add.php" method="POST">
            <h3 style="margin-bottom: 20px;">Detail Sesi</h3>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Berlaku Untuk Hari</label>
                <select name="hari" required>
                    <option value="semua">Semua Hari (Senin-Sabtu)</option>
                    <option value="senin">Senin</option>
                    <option value="selasa">Selasa</option>
                    <option value="rabu">Rabu</option>
                    <option value="kamis">Kamis</option>
                    <option value="jumat">Jumat</option>
                    <option value="sabtu">Sabtu</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Sesi Ke-</label>
                    <input type="number" name="sesi" placeholder="1" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jenis Kegiatan</label>
                    <select name="jenis">
                        <option value="normal">KBM Normal</option>
                        <option value="istirahat">Istirahat</option>
                        <option value="upacara">Upacara</option>
                        <option value="literasi">Literasi/Doa</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jam Mulai</label>
                    <input type="time" name="jam_mulai" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jam Selesai</label>
                    <input type="time" name="jam_selesai" required>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Keterangan</label>
                <input type="text" name="keterangan" placeholder="Contoh: Jam Pertama">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status</label>
                <select name="status">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>