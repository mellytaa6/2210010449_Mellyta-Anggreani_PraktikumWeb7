<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Latest Attendance Records
$sql = "SELECT absensi.*, 
        students.nama_lengkap as nama_siswa,
        subjects.nama_mapel,
        users.nama_lengkap as nama_guru,
        classes.nama_kelas
        FROM absensi
        JOIN students ON absensi.siswa_id = students.id
        JOIN subjects ON absensi.mapel_id = subjects.id
        JOIN users ON absensi.guru_id = users.id
        LEFT JOIN classes ON students.kelas_id = classes.id
        ORDER BY absensi.tanggal DESC, absensi.waktu_absen DESC
        LIMIT 50";

$result = $conn->query($sql);
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Riwayat Absensi</h1>
        <a href="input.php" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Input Absensi
        </a>
    </div>

    <div class="card glass">
        <table>
            <thead>
                <tr>
                    <th>Tanggal / Waktu</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Mapel (Sesi)</th>
                    <th>Status</th>
                    <th>Guru</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <div style="font-weight: bold;">
                                <?= date('d M Y', strtotime($row['tanggal'])) ?>
                            </div>
                            <small style="color: var(--text-muted);">
                                <?= date('H:i', strtotime($row['waktu_absen'])) ?>
                            </small>
                        </td>
                        <td>
                            <?= $row['nama_siswa'] ?>
                        </td>
                        <td>
                            <?= $row['nama_kelas'] ?>
                        </td>
                        <td>
                            <div>
                                <?= $row['nama_mapel'] ?>
                            </div>
                            <small style="color: var(--text-muted);">Sesi
                                <?= $row['sesi'] ?>
                            </small>
                        </td>
                        <td>
                            <?php
                            $badges = [
                                'hadir' => ['bg' => '#10b981', 'text' => 'Hadir'],
                                'sakit' => ['bg' => '#f59e0b', 'text' => 'Sakit'],
                                'izin' => ['bg' => '#3b82f6', 'text' => 'Izin'],
                                'alfa' => ['bg' => '#ef4444', 'text' => 'Alfa']
                            ];
                            $status = $row['status'];
                            $badge = $badges[$status];
                            ?>
                            <span
                                style="background: <?= $badge['bg'] ?>; padding: 4px 8px; border-radius: 4px; color: #fff; font-size: 0.8rem; text-transform: uppercase;">
                                <?= $badge['text'] ?>
                            </span>
                        </td>
                        <td>
                            <?= $row['nama_guru'] ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>