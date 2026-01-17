<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $_GET['id'];
$row = $conn->query("SELECT * FROM poin_prestasi WHERE id = $id")->fetch_assoc();
$students = $conn->query("SELECT * FROM students WHERE status='aktif' ORDER BY nama_lengkap ASC");
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Edit Prestasi</h1>
    </div>

    <div class="card glass" style="max-width: 800px;">
        <form action="process_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Pilih Siswa</label>
                <select name="siswa_id" required class="select2">
                    <option value="">-- Cari Siswa --</option>
                    <?php while ($s = $students->fetch_assoc()): ?>
                        <option value="<?= $s['id'] ?>" <?= $row['siswa_id'] == $s['id'] ? 'selected' : '' ?>>
                            <?= $s['nama_lengkap'] ?> (
                            <?= $s['nisn'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Prestasi /
                        Kegiatan</label>
                    <input type="text" name="nama_prestasi" value="<?= $row['nama_prestasi'] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal</label>
                    <input type="date" name="tanggal" value="<?= $row['tanggal'] ?>" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jenis</label>
                    <select name="jenis_prestasi">
                        <option value="akademik" <?= $row['jenis_prestasi'] == 'akademik' ? 'selected' : '' ?>>Akademik
                        </option>
                        <option value="non-akademik" <?= $row['jenis_prestasi'] == 'non-akademik' ? 'selected' : '' ?>
                            >Non-Akademik</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kategori</label>
                    <select name="kategori">
                        <option value="prestasi" <?= $row['kategori'] == 'prestasi' ? 'selected' : '' ?>>Prestasi (Juara)
                        </option>
                        <option value="penghargaan" <?= $row['kategori'] == 'penghargaan' ? 'selected' : '' ?>>Penghargaan
                        </option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tingkat</label>
                    <select name="tingkat">
                        <option value="sekolah" <?= $row['tingkat'] == 'sekolah' ? 'selected' : '' ?>>Sekolah</option>
                        <option value="kecamatan" <?= $row['tingkat'] == 'kecamatan' ? 'selected' : '' ?>>Kecamatan
                        </option>
                        <option value="kabupaten" <?= $row['tingkat'] == 'kabupaten' ? 'selected' : '' ?>>Kabupaten/Kota
                        </option>
                        <option value="provinsi" <?= $row['tingkat'] == 'provinsi' ? 'selected' : '' ?>>Provinsi</option>
                        <option value="nasional" <?= $row['tingkat'] == 'nasional' ? 'selected' : '' ?>>Nasional</option>
                        <option value="internasional" <?= $row['tingkat'] == 'internasional' ? 'selected' : '' ?>
                            >Internasional</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Peringkat</label>
                    <select name="peringkat">
                        <option value="juara_1" <?= $row['peringkat'] == 'juara_1' ? 'selected' : '' ?>>Juara 1</option>
                        <option value="juara_2" <?= $row['peringkat'] == 'juara_2' ? 'selected' : '' ?>>Juara 2</option>
                        <option value="juara_3" <?= $row['peringkat'] == 'juara_3' ? 'selected' : '' ?>>Juara 3</option>
                        <option value="harapan_1" <?= $row['peringkat'] == 'harapan_1' ? 'selected' : '' ?>>Harapan 1
                        </option>
                        <option value="harapan_2" <?= $row['peringkat'] == 'harapan_2' ? 'selected' : '' ?>>Harapan 2
                        </option>
                        <option value="partisipasi" <?= $row['peringkat'] == 'partisipasi' ? 'selected' : '' ?>>Partisipasi
                        </option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Poin</label>
                    <input type="number" name="poin" value="<?= $row['poin'] ?>" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Penyelenggara</label>
                    <input type="text" name="penyelenggara" value="<?= $row['penyelenggara'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Lokasi</label>
                    <input type="text" name="lokasi" value="<?= $row['lokasi'] ?>">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Deskripsi</label>
                <textarea name="deskripsi" rows="3"><?= $row['deskripsi'] ?></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status Approval</label>
                <select name="status">
                    <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= $row['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected" <?= $row['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
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