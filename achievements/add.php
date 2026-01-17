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
        <h1 class="page-title">Tambah Prestasi</h1>
    </div>

    <div class="card glass" style="max-width: 800px;">
        <form action="process_add.php" method="POST" enctype="multipart/form-data">

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Pilih Siswa</label>
                <select name="siswa_id" required class="select2">
                    <option value="">-- Cari Siswa --</option>
                    <?php while ($s = $students->fetch_assoc()): ?>
                        <option value="<?= $s['id'] ?>">
                            <?= $s['nama_lengkap'] ?> (
                            <?= $s['nisn'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <h3
                style="margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; color: var(--accent);">
                Detail Prestasi</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Prestasi /
                        Kegiatan</label>
                    <input type="text" name="nama_prestasi" placeholder="Contoh: Lomba Olimpiade Matematika" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal</label>
                    <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jenis</label>
                    <select name="jenis_prestasi">
                        <option value="akademik">Akademik</option>
                        <option value="non-akademik">Non-Akademik</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kategori</label>
                    <select name="kategori">
                        <option value="prestasi">Prestasi (Juara)</option>
                        <option value="penghargaan">Penghargaan</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tingkat</label>
                    <select name="tingkat">
                        <option value="sekolah">Sekolah</option>
                        <option value="kecamatan">Kecamatan</option>
                        <option value="kabupaten">Kabupaten/Kota</option>
                        <option value="provinsi">Provinsi</option>
                        <option value="nasional">Nasional</option>
                        <option value="internasional">Internasional</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Peringkat</label>
                    <select name="peringkat">
                        <option value="juara_1">Juara 1</option>
                        <option value="juara_2">Juara 2</option>
                        <option value="juara_3">Juara 3</option>
                        <option value="harapan_1">Harapan 1</option>
                        <option value="harapan_2">Harapan 2</option>
                        <option value="harapan_3">Harapan 3</option>
                        <option value="partisipasi">Partisipasi</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Poin</label>
                    <input type="number" name="poin" value="10" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Penyelenggara</label>
                    <input type="text" name="penyelenggara">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Lokasi</label>
                    <input type="text" name="lokasi">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Deskripsi</label>
                <textarea name="deskripsi" rows="3"></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Upload Sertifikat /
                    Foto</label>
                <input type="file" name="foto" accept="image/*,.pdf">
                <small style="color: var(--text-muted);">Max 2MB (JPG, PNG, PDF)</small>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>