<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Edit User</h1>
    </div>

    <div class="card glass" style="max-width: 800px;">
        <form action="process_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <!-- Account Info -->
            <h3 style="margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">Akun &
                Peran</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Username</label>
                    <input type="text" name="username" value="<?= $user['username'] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Password Baru</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ubah">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Role</label>
                    <select name="role" required>
                        <option value="guru" <?= $user['role'] == 'guru' ? 'selected' : '' ?>>Guru</option>
                        <option value="staf" <?= $user['role'] == 'staf' ? 'selected' : '' ?>>Staf</option>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="siswa" <?= $user['role'] == 'siswa' ? 'selected' : '' ?>>Siswa</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status</label>
                    <select name="status" required>
                        <option value="aktif" <?= $user['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= $user['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        <option value="pensiun" <?= $user['status'] == 'pensiun' ? 'selected' : '' ?>>Pensiun</option>
                    </select>
                </div>
            </div>

            <!-- Profile Info -->
            <h3
                style="margin-top: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">
                Data Pribadi</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?= $user['nama_lengkap'] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">NIP</label>
                    <input type="text" name="nip" value="<?= $user['nip'] ?>">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="<?= $user['tempat_lahir'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="<?= $user['tanggal_lahir'] ?>">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jenis Kelamin</label>
                    <select name="jenis_kelamin">
                        <option value="L" <?= $user['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= $user['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">No. Telepon</label>
                    <input type="text" name="no_telepon" value="<?= $user['no_telepon'] ?>">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Email</label>
                <input type="email" name="email" value="<?= $user['email'] ?>">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Alamat</label>
                <textarea name="alamat" rows="3"><?= $user['alamat'] ?></textarea>
            </div>

            <!-- Job Info -->
            <h3
                style="margin-top: 20px; margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">
                Jabatan & Foto</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Jabatan</label>
                    <input type="text" name="jabatan" value="<?= $user['jabatan'] ?>">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Bidang Studi</label>
                    <input type="text" name="bidang_studi" value="<?= $user['bidang_studi'] ?>">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Foto Profil</label>
                <?php if ($user['foto']): ?>
                    <div style="margin-bottom: 10px;">
                        <img src="../assets/uploads/<?= $user['foto'] ?>"
                            style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                    </div>
                <?php endif; ?>
                <input type="file" name="foto" accept="image/*" style="padding: 8px;">
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>