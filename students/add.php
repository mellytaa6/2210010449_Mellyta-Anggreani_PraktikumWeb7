<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$classes = $conn->query("SELECT * FROM classes ORDER BY nama_kelas ASC");
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Tambah Siswa</h1>
    </div>

    <div class="card glass">
        <form action="process_add.php" method="POST" enctype="multipart/form-data">

            <!-- 1. Data Sekolah -->
            <h3
                style="margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; color: var(--accent);">
                Data Sekolah</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">NIS *</label>
                    <input type="text" name="nis" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">NISN *</label>
                    <input type="text" name="nisn" required>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kelas</label>
                    <select name="kelas_id">
                        <option value="">Pilih Kelas</option>
                        <?php while ($c = $classes->fetch_assoc()): ?>
                            <option value="<?= $c['id'] ?>"><?= $c['nama_kelas'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tahun Masuk</label>
                    <input type="number" name="tahun_masuk" value="<?= date('Y') ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status</label>
                    <select name="status">
                        <option value="aktif">Aktif</option>
                        <option value="alumni">Alumni</option>
                        <option value="pindah">Pindah</option>
                        <option value="keluar">Keluar</option>
                    </select>
                </div>
            </div>

            <!-- 2. Data Pribadi -->
            <h3
                style="margin-top: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; color: var(--accent);">
                Data Pribadi</h3>
            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Agama</label>
                    <select name="agama">
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">No. Telepon
                        Siswa</label>
                    <input type="text" name="no_telepon">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Email</label>
                    <input type="email" name="email">
                </div>
            </div>

            <!-- 3. Alamat -->
            <h3
                style="margin-top: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; color: var(--accent);">
                Alamat Lengkap</h3>
            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jalan / Alamat</label>
                <textarea name="alamat" rows="2"></textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">RT / RW</label>
                    <input type="text" name="rt_rw" placeholder="001/002">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kelurahan</label>
                    <input type="text" name="kelurahan">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kecamatan</label>
                    <input type="text" name="kecamatan">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kota /
                        Kabupaten</label>
                    <input type="text" name="kota">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Provinsi</label>
                    <input type="text" name="provinsi">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kode Pos</label>
                    <input type="text" name="kode_pos">
                </div>
            </div>

            <!-- 4. Data Orang Tua -->
            <h3
                style="margin-top: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; color: var(--accent);">
                Data Orang Tua</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Ayah</label>
                    <input type="text" name="nama_ayah">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Ibu</label>
                    <input type="text" name="nama_ibu">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu">
                </div>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">No. Telepon Orang
                    Tua</label>
                <input type="text" name="no_telepon_ortu">
            </div>

            <!-- Foto -->
            <div
                style="margin-top: 20px; margin-bottom: 20px; border-top: 1px solid var(--glass-border); padding-top: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Foto Siswa</label>
                <input type="file" name="foto" accept="image/*" style="padding: 8px;">
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan Data Siswa</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>