<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$sql = "SELECT * FROM jam_pelajaran ORDER BY FIELD(hari, 'semua','senin','selasa','rabu','kamis','jumat','sabtu','minggu'), sesi ASC";
$result = $conn->query($sql);
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Manajemen Jam Pelajaran</h1>
        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Sesi
        </a>
    </div>

    <div class="card glass">
        <table>
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Sesi Ke</th>
                    <th>Waktu</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if ($row['hari'] == 'semua'): ?>
                                <span class="badge" style="background: rgba(255,255,255,0.1);">Setiap Hari</span>
                            <?php else: ?>
                                <?= ucfirst($row['hari']) ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div
                                style="font-weight: bold; width: 30px; height: 30px; background: var(--glass-bg); display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                <?= $row['sesi'] ?>
                            </div>
                        </td>
                        <td>
                            <span style="color: var(--accent); font-weight: bold;">
                                <?= date('H:i', strtotime($row['jam_mulai'])) ?>
                            </span> -
                            <span style="color: var(--accent); font-weight: bold;">
                                <?= date('H:i', strtotime($row['jam_selesai'])) ?>
                            </span>
                        </td>
                        <td>
                            <?= $row['keterangan'] ?? '-' ?>
                        </td>
                        <td>
                            <?php
                            $colors = [
                                'normal' => '#60a5fa',
                                'istirahat' => '#f59e0b',
                                'upacara' => '#a78bfa',
                                'literasi' => '#34d399'
                            ];
                            $color = $colors[$row['jenis']] ?? 'white';
                            ?>
                            <span style="color: <?= $color ?>; text-transform: capitalize;">
                                <?= $row['jenis'] ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'aktif'): ?>
                                <span style="color: #10b981;">Aktif</span>
                            <?php else: ?>
                                <span style="color: #ef4444;">
                                    <?= ucfirst($row['status']) ?>
                                </span>
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