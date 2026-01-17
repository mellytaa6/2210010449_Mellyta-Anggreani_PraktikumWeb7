<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Fetch Categories
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';
$where = $type_filter ? "WHERE jenis='$type_filter'" : "";
$sql = "SELECT * FROM poin_kategori $where ORDER BY jenis ASC, nama_kategori ASC";
$result = $conn->query($sql);
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Master Kategori Poin</h1>
        <div class="actions">
            <a href="add.php" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Type Filter -->
    <div class="card glass" style="margin-bottom: 20px; padding: 15px;">
        <span style="margin-right: 15px; color: var(--text-muted);">Filter:</span>
        <a href="idx.php" class="btn"
            style="background: <?= $type_filter == '' ? 'var(--primary)' : 'rgba(255,255,255,0.1)' ?>; font-size: 0.8rem;">Semua</a>
        <a href="idx.php?type=prestasi" class="btn"
            style="background: <?= $type_filter == 'prestasi' ? '#10b981' : 'rgba(255,255,255,0.1)' ?>; font-size: 0.8rem;">Prestasi</a>
        <a href="idx.php?type=pelanggaran" class="btn"
            style="background: <?= $type_filter == 'pelanggaran' ? '#ef4444' : 'rgba(255,255,255,0.1)' ?>; font-size: 0.8rem;">Pelanggaran</a>
    </div>

    <div class="card glass">
        <table>
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Nama Kategori</th>
                    <th>Range Poin</th>
                    <th>Detail (Sanksi/Penghargaan)</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php
                            $badges = [
                                'prestasi' => ['bg' => '#10b981', 'text' => 'Prestasi'],
                                'pelanggaran' => ['bg' => '#ef4444', 'text' => 'Pelanggaran']
                            ];
                            $b = $badges[$row['jenis']];
                            ?>
                            <span class="badge" style="background: <?= $b['bg'] ?>;">
                                <?= $b['text'] ?>
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: bold;">
                                <?= $row['nama_kategori'] ?>
                            </div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                <?= $row['deskripsi'] ?>
                            </div>
                        </td>
                        <td>
                            <?= $row['poin_min'] ?> -
                            <?= $row['poin_max'] ?>
                        </td>
                        <td>
                            <?php if ($row['jenis'] == 'pelanggaran'): ?>
                                <div style="font-size: 0.8rem;"><strong>Sanksi:</strong>
                                    <?= $row['sanksi'] ?? '-' ?>
                                </div>
                            <?php else: ?>
                                <div style="font-size: 0.8rem;"><strong>Reward:</strong>
                                    <?= $row['penghargaan'] ?? '-' ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'aktif'): ?>
                                <span style="color: #10b981;">Aktif</span>
                            <?php else: ?>
                                <span style="color: #ef4444;">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" style="color: var(--accent); margin-right: 10px;"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <a href="delete.php?id=<?= $row['id'] ?>" style="color: #ef4444;"
                                onclick="return confirm('Hapus kategori ini? Data yang sudah ada tidak akan hilang.')"><i
                                    class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>