<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$result = $conn->query("SELECT * FROM semester ORDER BY tahun_ajaran DESC, semester DESC");
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Master Data Semester</h1>
        <div class="actions">
             <a href="add.php" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Semester
            </a>
        </div>
    </div>

    <div class="card glass">
        <table>
            <thead>
                <tr>
                    <th>Tahun Ajaran</th>
                    <th>Semester</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr style="<?= $row['status'] == 'aktif' ? 'background: rgba(16, 185, 129, 0.1);' : '' ?>">
                    <td style="font-weight: bold; font-size: 1.1rem;"><?= $row['tahun_ajaran'] ?></td>
                    <td><?= ucfirst($row['semester']) ?></td>
                    <td>
                        <?= date('d M Y', strtotime($row['tanggal_mulai'])) ?> - <?= date('d M Y', strtotime($row['tanggal_selesai'])) ?>
                    </td>
                    <td>
                        <?php if($row['status'] == 'aktif'): ?>
                            <span class="badge" style="background: #10b981; color: #fff;">AKTIF</span>
                        <?php elseif($row['status'] == 'selesai'): ?>
                            <span class="badge" style="background: rgba(255,255,255,0.1);">Selesai</span>
                        <?php else: ?>
                            <span class="badge" style="background: #f59e0b; color: #fff;">Akan Datang</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($row['status'] != 'aktif'): ?>
                            <a href="set_active.php?id=<?= $row['id'] ?>" class="btn" style="padding: 5px 10px; font-size: 0.8rem; background: rgba(16, 185, 129, 0.2); color: #10b981; margin-right: 5px;" onclick="return confirm('Set semester ini sebagai Aktif? Semester lain akan diset selesai.')">Set Aktif</a>
                        <?php endif; ?>
                        
                        <a href="edit.php?id=<?= $row['id'] ?>" style="color: var(--accent); margin-right: 10px;"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
