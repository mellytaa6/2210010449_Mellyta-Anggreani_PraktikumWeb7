<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Tambah Kategori Poin</h1>
    </div>

    <div class="card glass" style="max-width: 800px;">
        <form action="process_add.php" method="POST">

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jenis</label>
                <select name="jenis" id="jenis" onchange="toggleFields()" required>
                    <option value="prestasi">Prestasi</option>
                    <option value="pelanggaran">Pelanggaran</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Kategori</label>
                <input type="text" name="nama_kategori" placeholder="Contoh: Terlambat, Juara Kelas" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Deskripsi</label>
                <textarea name="deskripsi" rows="2"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Poin Min</label>
                    <input type="number" name="poin_min" value="0">
                </div>
                <div>
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Poin Max</label>
                    <input type="number" name="poin_max" value="0">
                </div>
            </div>

            <div id="field-sanksi" style="margin-bottom: 20px; display: none;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Sanksi (Untuk
                    Pelanggaran)</label>
                <textarea name="sanksi" rows="2" placeholder="Contoh: Panggilan ortu, skorsing"></textarea>
            </div>

            <div id="field-reward" style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Penghargaan (Untuk
                    Prestasi)</label>
                <textarea name="penghargaan" rows="2" placeholder="Contoh: Sertifikat, Beasiswa"></textarea>
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

<script>
    function toggleFields() {
        const jenis = document.getElementById('jenis').value;
        const sanksi = document.getElementById('field-sanksi');
        const reward = document.getElementById('field-reward');

        if (jenis === 'pelanggaran') {
            sanksi.style.display = 'block';
            reward.style.display = 'none';
        } else {
            sanksi.style.display = 'none';
            reward.style.display = 'block';
        }
    }
    // Init
    toggleFields();
</script>

<?php include '../includes/footer.php'; ?>