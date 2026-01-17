<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Tambah Semester</h1>
    </div>

    <div class="card glass" style="max-width: 600px;">
        <form action="process_add.php" method="POST">

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" placeholder="e.g. 2024/2025" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Semester</label>
                <select name="semester" required>
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" required>
                </div>
                <div>
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" required>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status</label>
                <select name="status">
                    <option value="akan_datang">Akan Datang</option>
                    <option value="aktif">Aktif</option>
                    <option value="selesai">Selesai</option>
                </select>
                <small style="color: var(--text-muted); margin-top: 5px; display: block;">* Jika set Aktif, semester
                    lain otomatis akan dinonaktifkan.</small>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>