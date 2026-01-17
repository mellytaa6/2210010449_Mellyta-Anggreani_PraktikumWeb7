<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$sql = "SELECT classes.*, users.nama_lengkap as walikelas 
        FROM classes 
        LEFT JOIN users ON classes.wali_kelas_id = users.id 
        ORDER BY tingkat ASC, nama_kelas ASC";
$result = $conn->query($sql);
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Manajemen Kelas</h1>
        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Kelas
        </a>
    </div>

    <div class="card glass">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Kelas</th>
                    <th>Tingkat</th>
                    <th>Jurusan</th>
                    <th>Wali Kelas</th>
                    <th>Ruang</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['kode_kelas'] ?></td>
                        <td style="font-weight: bold; color: var(--accent);"><?= $row['nama_kelas'] ?></td>
                        <td><span class="badge" style="background: rgba(255,255,255,0.1);"><?= $row['tingkat'] ?></span>
                        </td>
                        <td><?= $row['jurusan'] ?? '-' ?></td>
                        <td><?= $row['walikelas'] ?? '<span style="color: red;">Belum ada</span>' ?></td>
                        <td><?= $row['ruangan'] ?? '-' ?></td>
                        <td><?= $row['kapasitas'] ?> Siswa</td>
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
                            <a href="delete.php?id=<?= $row['id'] ?>" style="color: #ef4444;"
                                onclick="return confirm('Yakin hapus?')"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>