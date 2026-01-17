<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Fetch Violations
$sql = "SELECT poin_pelanggaran.*, students.nama_lengkap, students.nisn, students.kelas_id, classes.nama_kelas 
        FROM poin_pelanggaran 
        JOIN students ON poin_pelanggaran.siswa_id = students.id 
        LEFT JOIN classes ON students.kelas_id = classes.id
        ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Poin Pelanggaran Siswa</h1>
        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Lapor Pelanggaran
        </a>
    </div>

    <div class="card glass">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Siswa (Kelas)</th>
                    <th>Pelanggaran</th>
                    <th>Jenis</th>
                    <th>Poin</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                        <td>
                            <div style="font-weight: bold;"><?= $row['nama_lengkap'] ?></div>
                            <small style="color: var(--text-muted);"><?= $row['nama_kelas'] ?> (<?= $row['nisn'] ?>)</small>
                        </td>
                        <td>
                            <div style="font-weight: bold; color: var(--accent);"><?= $row['kategori_pelanggaran'] ?></div>
                            <div
                                style="font-size: 0.8rem; color: var(--text-muted); max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?= $row['deskripsi'] ?>
                            </div>
                        </td>
                        <td>
                            <?php
                            $badges = [
                                'ringan' => ['bg' => 'rgba(255,255,255,0.1)', 'color' => '#fff'],
                                'sedang' => ['bg' => '#f59e0b', 'color' => '#fff'],
                                'berat' => ['bg' => '#ef4444', 'color' => '#fff']
                            ];
                            $type = $badges[$row['jenis_pelanggaran']];
                            ?>
                            <span class="badge"
                                style="background: <?= $type['bg'] ?>; color: <?= $type['color'] ?>;"><?= ucfirst($row['jenis_pelanggaran']) ?></span>
                        </td>
                        <td style="font-weight: bold; color: #ef4444;"><?= $row['poin'] ?></td>
                        <td>
                            <?php if ($row['status'] == 'selesai'): ?>
                                <span style="color: #10b981; font-weight: bold;">Selesai</span>
                            <?php elseif ($row['status'] == 'ditindak'): ?>
                                <span style="color: #3b82f6; font-weight: bold;">Ditindak</span>
                            <?php else: ?>
                                <span style="color: #f59e0b; font-weight: bold;">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" style="color: var(--accent); margin-right: 10px;"
                                title="Tindak Lanjut"><i class="fa-solid fa-gavel"></i></a>
                            <a href="delete.php?id=<?= $row['id'] ?>" style="color: #ef4444;"
                                onclick="return confirm('Yakin hapus? Poin siswa akan dikurangi.')"><i
                                    class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>