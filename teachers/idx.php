<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$sql = "SELECT * FROM users ORDER BY nama_lengkap ASC";
$result = $conn->query($sql);
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Manajemen Guru & Staff</h1>
        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah User
        </a>
    </div>

    <div class="card glass">
        <table style="font-size: 0.9rem;">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama & NIP</th>
                    <th>Jabatan/Role</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if ($row['foto']): ?>
                                <img src="../assets/uploads/<?= $row['foto'] ?>"
                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            <?php else: ?>
                                <div class="avatar" style="width: 40px; height: 40px; font-size: 0.8rem;">
                                    <?= substr($row['nama_lengkap'], 0, 1) ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="font-weight: bold;"><?= $row['nama_lengkap'] ?></div>
                            <small style="color: var(--text-muted);"><?= $row['nip'] ?? '-' ?></small>
                        </td>
                        <td>
                            <div><?= $row['jabatan'] ?></div>
                            <span
                                style="background: rgba(255,255,255,0.05); color: var(--primary); padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; text-transform: uppercase;">
                                <?= $row['role'] ?>
                            </span>
                        </td>
                        <td>
                            <div><?= $row['email'] ?></div>
                            <small><?= $row['no_telepon'] ?></small>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'aktif'): ?>
                                <span style="color: #10b981;">Aktif</span>
                            <?php else: ?>
                                <span style="color: #ef4444;"><?= ucfirst($row['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" style="color: var(--accent); margin-right: 10px;"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <?php if ($row['username'] != 'admin'): ?>
                                <a href="delete.php?id=<?= $row['id'] ?>" style="color: #ef4444;"
                                    onclick="return confirm('Yakin hapus?')"><i class="fa-solid fa-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>