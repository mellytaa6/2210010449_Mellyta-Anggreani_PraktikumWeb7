<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $_GET['id'];
$row = $conn->query("SELECT * FROM tahun_ajaran WHERE id = $id")->fetch_assoc();
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Edit Tahun Ajaran</h1>
    </div>

    <div class="card glass" style="max-width: 600px;">
        <form action="process_edit.php" method="POST">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" value="<?= $row['tahun_ajaran'] ?>" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="<?= $row['tanggal_mulai'] ?>" required>
                </div>
                <div>
                    <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="<?= $row['tanggal_selesai'] ?>" required>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Status</label>
                <select name="status">
                    <option value="akan_datang" <?= $row['status'] == 'akan_datang' ? 'selected' : '' ?>>Akan Datang
                    </option>
                    <option value="aktif" <?= $row['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="selesai" <?= $row['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="idx.php" class="btn" style="background: rgba(255,255,255,0.1);">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>