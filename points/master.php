<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Handle Add
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_master'])) {
    $type = $_POST['type'];
    $description = $_POST['description'];
    $points = $_POST['points'];
    $conn->query("INSERT INTO points_master (type, description, points) VALUES ('$type', '$description', $points)");
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM points_master WHERE id = $id");
    header("Location: master.php");
}

$masters = $conn->query("SELECT * FROM points_master ORDER BY type ASC");
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Master Data Poin</h1>
        <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Kembali ke Riwayat</a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
        <!-- Add Form -->
        <div class="card glass">
            <h3>Tambah Kategori</h3>
            <form method="POST" style="margin-top: 20px;">
                <input type="hidden" name="add_master" value="1">
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tipe</label>
                    <select name="type" required>
                        <option value="pelanggaran">Pelanggaran</option>
                        <option value="prestasi">Prestasi</option>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Keterangan</label>
                    <input type="text" name="description" placeholder="Contoh: Terlambat" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Poin</label>
                    <input type="number" name="points" placeholder="Contoh: 5" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>

        <!-- List -->
        <div class="card glass">
            <h3>Daftar Kategori Poin</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tipe</th>
                        <th>Keterangan</th>
                        <th>Poin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $masters->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php if ($row['type'] == 'prestasi'): ?>
                                    <span style="color: #10b981; font-weight: bold;">Prestasi</span>
                                <?php else: ?>
                                    <span style="color: #ef4444; font-weight: bold;">Pelanggaran</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $row['description'] ?>
                            </td>
                            <td>
                                <?= $row['points'] ?>
                            </td>
                            <td>
                                <a href="master.php?delete=<?= $row['id'] ?>" style="color: #ef4444;"
                                    onclick="return confirm('Hapus?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>