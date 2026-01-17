<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$sql = "SELECT subjects.*, users.nama_lengkap as guru_pengampu 
        FROM subjects 
        LEFT JOIN users ON subjects.guru_id = users.id 
        ORDER BY tingkat ASC, nama_mapel ASC";
$result = $conn->query($sql);
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Manajemen Mata Pelajaran</h1>
        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Mapel
        </a>
    </div>

    <div class="card glass">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Mapel</th>
                    <th>Tingkat</th>
                    <th>Kategori</th>
                    <th>Guru Pengampu</th>
                    <th>Jam/Minggu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['kode_mapel'] ?></td>
                        <td style="font-weight: bold; color: var(--accent);"><?= $row['nama_mapel'] ?></td>
                        <td><span class="badge" style="background: rgba(255,255,255,0.1);"><?= $row['tingkat'] ?></span>
                        </td>
                        <td><?= ucfirst($row['kategori']) ?></td>
                        <td><?= $row['guru_pengampu'] ?? '-' ?></td>
                        <td><?= $row['jam_per_minggu'] ?> Jam</td>
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