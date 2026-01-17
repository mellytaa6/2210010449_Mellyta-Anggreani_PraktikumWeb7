<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Fetch Achievements
$sql = "SELECT poin_prestasi.*, students.nama_lengkap, students.nisn 
        FROM poin_prestasi 
        JOIN students ON poin_prestasi.siswa_id = students.id 
        ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Data Prestasi Siswa</h1>
        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Prestasi
        </a>
    </div>

    <div class="card glass">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>Prestasi</th>
                    <th>Tingkat / Peringkat</th>
                    <th>Poin</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?= date('d M Y', strtotime($row['tanggal'])) ?>
                        </td>
                        <td>
                            <div style="font-weight: bold;">
                                <?= $row['nama_lengkap'] ?>
                            </div>
                            <small style="color: var(--text-muted);">
                                <?= $row['nisn'] ?>
                            </small>
                        </td>
                        <td>
                            <div style="font-weight: bold; color: var(--accent);">
                                <?= $row['nama_prestasi'] ?>
                            </div>
                            <small style="color: var(--text-muted);">
                                <?= ucfirst($row['jenis_prestasi']) ?> -
                                <?= ucfirst($row['kategori']) ?>
                            </small>
                        </td>
                        <td>
                            <span class="badge" style="background: rgba(255,255,255,0.1);">
                                <?= ucfirst($row['tingkat']) ?>
                            </span>
                            <div style="font-size: 0.8rem; margin-top: 5px;">
                                <?= ucfirst(str_replace('_', ' ', $row['peringkat'])) ?>
                            </div>
                        </td>
                        <td style="font-weight: bold; color: #10b981;">+
                            <?= $row['poin'] ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'approved'): ?>
                                <span style="color: #10b981; font-weight: bold;">Disetujui</span>
                            <?php elseif ($row['status'] == 'rejected'): ?>
                                <span style="color: #ef4444; font-weight: bold;">Ditolak</span>
                            <?php else: ?>
                                <span style="color: #f59e0b; font-weight: bold;">Menunggu</span>
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