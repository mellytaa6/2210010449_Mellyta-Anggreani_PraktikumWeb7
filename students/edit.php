<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $_GET['id'];
$student = $conn->query("SELECT * FROM students WHERE id = $id")->fetch_assoc();
$classes = $conn->query("SELECT * FROM classes ORDER BY nama_kelas ASC");
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Edit Siswa</h1>
    </div>

    <div class="card glass">
        <form action="process_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">

            <!-- 1. Data Sekolah -->
            <h3
                style="margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; color: var(--accent);">
                Data Sekolah</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">NIS *</label>
                    <input type="text" name="nis" value="<?= $student['nis'] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">NISN *</label>
                    <input type="text" name="nisn" value="<?= $student['nisn'] ?>" required>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kelas</label>
                    <select name="kelas_id">
                        <option value="">Pilih Kelas</option>
                        <?php while ($c = $classes->fetch_assoc()): ?>
                            <option value="<?= $c['id'] ?>" <?= $student['kelas_id'] == $c['id'] ? 'selected' : '' ?>>
                                <?= $c['nama_kelas'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tahun Masuk</label>
                    <input type="number" name="tahun_masuk" value="<?= $student['tahun_masuk'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status</label>
                    <select name="status">
                        <option value="aktif" <?= $student['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="alumni" <?= $student['status'] == 'alumni' ? 'selected' : '' ?>>Alumni</option>
                        <option value="pindah" <?= $student['status'] == 'pindah' ? 'selected' : '' ?>>Pindah</option>
                        <option value="keluar" <?= $student['status'] == 'keluar' ? 'selected' : '' ?>>Keluar</option>
                    </select>
                </div>
            </div>

            <!-- 2. Data Pribadi -->
            <h3
                style="margin-top: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; color: var(--accent);">
                Data Pribadi</h3>
            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" value="<?= $student['nama_lengkap'] ?>" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="<?= $student['tempat_lahir'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="<?= $student['tanggal_lahir'] ?>">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required>
                        <option value="L" <?= $student['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= $student['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Agama</label>
                    <select name="agama">
                        <?php
                        $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
                        foreach ($agamas as $ag):
                            ?>
                            <option value="<?= $ag ?>" <?= $student['agama'] == $ag ? 'selected' : '' ?>><?= $ag ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">No. Telepon
                        Siswa</label>
                    <input type="text" name="no_telepon" value="<?= $student['no_telepon'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Email</label>
                    <input type="email" name="email" value="<?= $student['email'] ?>">
                </div>
            </div>

            <!-- 3. Alamat -->
            <h3
                style="margin-top: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; color: var(--accent);">
                Alamat Lengkap</h3>
            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jalan / Alamat</label>
                <textarea name="alamat" rows="2"><?= $student['alamat'] ?></textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">RT / RW</label>
                    <input type="text" name="rt_rw" value="<?= $student['rt_rw'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kelurahan</label>
                    <input type="text" name="kelurahan" value="<?= $student['kelurahan'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kecamatan</label>
                    <input type="text" name="kecamatan" value="<?= $student['kecamatan'] ?>">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kota /
                        Kabupaten</label>
                    <input type="text" name="kota" value="<?= $student['kota'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Provinsi</label>
                    <input type="text" name="provinsi" value="<?= $student['provinsi'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kode Pos</label>
                    <input type="text" name="kode_pos" value="<?= $student['kode_pos'] ?>">
                </div>
            </div>

            <!-- 4. Data Orang Tua -->
            <h3
                style="margin-top: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px; color: var(--accent);">
                Data Orang Tua</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="<?= $student['nama_ayah'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" value="<?= $student['pekerjaan_ayah'] ?>">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="<?= $student['nama_ibu'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" value="<?= $student['pekerjaan_ibu'] ?>">
                </div>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">No. Telepon Orang
                    Tua</label>
                <input type="text" name="no_telepon_ortu" value="<?= $student['no_telepon_ortu'] ?>">
            </div>

            <!-- Foto -->
            <div
                style="margin-top: 20px; margin-bottom: 20px; border-top: 1px solid var(--glass-border); padding-top: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Foto Siswa</label>
                <?php if ($student['foto']): ?>
                    <div style="margin-bottom: 10px;">
                        <img src="../assets/uploads/<?= $student['foto'] ?>"
                            style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                    </div>
                <?php endif; ?>
                <input type="file" name="foto" accept="image/*" style="padding: 8px;">
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update Data Siswa</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>