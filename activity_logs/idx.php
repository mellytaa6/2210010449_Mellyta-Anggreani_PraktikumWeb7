<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Pagination
$limit = 20;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch Logs
$sql = "SELECT activity_logs.*, users.nama_lengkap 
        FROM activity_logs 
        LEFT JOIN users ON activity_logs.user_id = users.id 
        ORDER BY created_at DESC 
        LIMIT $start, $limit";
$result = $conn->query($sql);

$total = $conn->query("SELECT MAX(id) FROM activity_logs")->fetch_row()[0];
$pages = ceil($total / $limit);
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Activity Logs</h1>
    </div>

    <div class="card glass">
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Modul / Aksi</th>
                    <th>Detail</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?= $row['created_at'] ?>
                        </td>
                        <td style="font-weight: bold;">
                            <?= $row['nama_lengkap'] ?>
                        </td>
                        <td>
                            <?= $row['activity'] ?>
                        </td>
                        <td>
                            <?php if ($row['module']): ?>
                                <span class="badge" style="background: rgba(255,255,255,0.1);">
                                    <?= $row['module'] ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($row['action']): ?>
                                <span class="badge" style="background: var(--primary);">
                                    <?= $row['action'] ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div
                                style="font-size: 0.8rem; color: var(--text-muted); max-width: 250px; overflow: hidden; text-overflow: ellipsis;">
                                <?= $row['details'] ?>
                            </div>
                        </td>
                        <td style="font-family: monospace;">
                            <?= $row['ip_address'] ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="margin-top: 20px; text-align: center;">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="btn"
                    style="<?= $i == $page ? 'background: var(--accent);' : 'background: rgba(255,255,255,0.1);' ?>; padding: 5px 10px; margin: 0 2px;">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>