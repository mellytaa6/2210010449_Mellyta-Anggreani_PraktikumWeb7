<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

include 'config/database.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Fetch Stats
$total_students = $conn->query("SELECT COUNT(*) as c FROM students")->fetch_assoc()['c'];
$total_teachers = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='guru'")->fetch_assoc()['c'];
$total_classes = $conn->query("SELECT COUNT(*) as c FROM classes")->fetch_assoc()['c'];
$total_subjects = $conn->query("SELECT COUNT(*) as c FROM subjects")->fetch_assoc()['c'];

?>

<div class="main-content">
    <?php
    $page_title = 'Dashboard Overview';
    include 'includes/topbar.php';
    ?>

    <!-- Stats Grid -->
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card glass">
            <div style="color: var(--text-muted); margin-bottom: 5px;">Total Siswa</div>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--primary);">
                <?= $total_students ?>
            </div>
            <i class="fa-solid fa-user-graduate"
                style="position: absolute; right: 20px; top: 20px; font-size: 3rem; opacity: 0.1;"></i>
        </div>
        <div class="card glass">
            <div style="color: var(--text-muted); margin-bottom: 5px;">Total Guru</div>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--secondary);">
                <?= $total_teachers ?>
            </div>
            <i class="fa-solid fa-chalkboard-user"
                style="position: absolute; right: 20px; top: 20px; font-size: 3rem; opacity: 0.1;"></i>
        </div>
        <div class="card glass">
            <div style="color: var(--text-muted); margin-bottom: 5px;">Total Kelas</div>
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--accent);">
                <?= $total_classes ?>
            </div>
            <i class="fa-solid fa-school"
                style="position: absolute; right: 20px; top: 20px; font-size: 3rem; opacity: 0.1;"></i>
        </div>
        <div class="card glass">
            <div style="color: var(--text-muted); margin-bottom: 5px;">Mata Pelajaran</div>
            <div style="font-size: 2.5rem; font-weight: 700; color: #facc15;">
                <?= $total_subjects ?>
            </div>
            <i class="fa-solid fa-book-open"
                style="position: absolute; right: 20px; top: 20px; font-size: 3rem; opacity: 0.1;"></i>
        </div>
    </div>

    <!-- Charts Area -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <div class="card glass">
            <h3 style="margin-bottom: 1.5rem;">Statistik Pelanggaran vs Prestasi</h3>
            <canvas id="pointsChart"></canvas>
        </div>
        <div class="card glass">
            <h3 style="margin-bottom: 1.5rem;">Quick Actions</h3>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="students/add.php" class="btn glass" style="justify-content: space-between;">
                    Tambah Siswa <i class="fa-solid fa-plus"></i>
                </a>
                <a href="points/add.php" class="btn glass" style="justify-content: space-between;">
                    Input Pelanggaran <i class="fa-solid fa-triangle-exclamation"></i>
                </a>
                <a href="schedules/idx.php" class="btn glass" style="justify-content: space-between;">
                    Lihat Jadwal <i class="fa-solid fa-calendar"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pointsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Prestasi',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(16, 185, 129, 0.5)',
                borderColor: '#10b981',
                borderWidth: 1
            },
            {
                label: 'Pelanggaran',
                data: [2, 3, 20, 5, 1, 4],
                backgroundColor: 'rgba(239, 68, 68, 0.5)',
                borderColor: '#ef4444',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.1)' } },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { labels: { color: '#94a3b8' } }
            }
        }
    });
</script>

<?php include 'includes/footer.php'; ?>