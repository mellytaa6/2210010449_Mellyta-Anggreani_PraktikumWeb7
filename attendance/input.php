<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Fetch Dropdown Data
$classes = $conn->query("SELECT * FROM classes WHERE status='aktif' ORDER BY nama_kelas ASC");
$subjects = $conn->query("SELECT * FROM subjects WHERE status='aktif' ORDER BY nama_mapel ASC");
// Use DISTINCT for sessions from jam_pelajaran
$sessions = $conn->query("SELECT DISTINCT sesi FROM jam_pelajaran WHERE status='aktif' AND jenis='normal' ORDER BY sesi ASC");

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$session = isset($_GET['session']) ? $_GET['session'] : '';

$students = [];
$existing_attendance = [];

if ($class_id && $subject_id && $date && $session) {
    // Fetch Students in Class
    $sql_students = "SELECT * FROM students WHERE kelas_id = $class_id AND status = 'aktif' ORDER BY nama_lengkap ASC";
    $res_students = $conn->query($sql_students);
    while($row = $res_students->fetch_assoc()) {
        $students[] = $row;
    }

    // Check for existing records to pre-fill
    $sql_check = "SELECT * FROM absensi WHERE mapel_id = $subject_id AND tanggal = '$date' AND sesi = $session";
    $res_check = $conn->query($sql_check);
    while($row = $res_check->fetch_assoc()) {
        $existing_attendance[$row['siswa_id']] = $row['status'];
    }
}
?>

<div class="main-content">
    <div class="top-bar">
        <h1 class="page-title">Input Absensi</h1>
    </div>

    <!-- Filter / Selection Form -->
    <div class="card glass" style="margin-bottom: 20px;">
        <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
            <div>
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Kelas</label>
                <select name="class_id" required style="width: 100%; margin-bottom: 0;">
                    <option value="">Pilih Kelas</option>
                    <?php 
                    $classes->data_seek(0);
                    while($c = $classes->fetch_assoc()): 
                    ?>
                        <option value="<?= $c['id'] ?>" <?= $class_id == $c['id'] ? 'selected' : '' ?>>
                            <?= $c['nama_kelas'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Mata Pelajaran</label>
                <select name="subject_id" required style="width: 100%; margin-bottom: 0;">
                    <option value="">Pilih Mapel</option>
                    <?php 
                    $subjects->data_seek(0);
                    while($s = $subjects->fetch_assoc()): 
                    ?>
                        <option value="<?= $s['id'] ?>" <?= $subject_id == $s['id'] ? 'selected' : '' ?>>
                            <?= $s['nama_mapel'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Tanggal</label>
                <input type="date" name="date" value="<?= $date ?>" required style="width: 100%; margin-bottom: 0;">
            </div>
            <div>
                <label style="color: var(--text-muted); display: block; margin-bottom: 8px;">Sesi</label>
                <select name="session" required style="width: 100%; margin-bottom: 0;">
                    <option value="">Pilih Sesi</option>
                    <?php 
                    if ($sessions->num_rows > 0) {
                        $sessions->data_seek(0);
                        while($s = $sessions->fetch_assoc()): 
                    ?>
                        <option value="<?= $s['sesi'] ?>" <?= $session == $s['sesi'] ? 'selected' : '' ?>>Sesi <?= $s['sesi'] ?></option>
                    <?php 
                        endwhile; 
                    } else {
                        for($i=1; $i<=10; $i++) {
                             $selected = ($session == $i) ? 'selected' : '';
                             echo "<option value='$i' $selected>Sesi $i</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fa-solid fa-magnifying-glass"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>

    <!-- Student List for Attendance -->
    <?php if ($class_id && $subject_id && $date && $session): ?>
        <?php if (!empty($students)): ?>
        <form action="process_input.php" method="POST">
            <input type="hidden" name="class_id" value="<?= $class_id ?>">
            <input type="hidden" name="subject_id" value="<?= $subject_id ?>">
            <input type="hidden" name="date" value="<?= $date ?>">
            <input type="hidden" name="session" value="<?= $session ?>">

            <div class="card glass">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                     <h3>Daftar Siswa</h3>
                     <div>
                         <button type="button" class="btn" style="padding: 5px 10px; font-size: 0.8rem;" onclick="setAll('hadir')">Semua Hadir</button>
                     </div>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th style="text-align: center;">Kehadiran</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $index => $student): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $student['nis'] ?></td>
                            <td style="font-weight: bold;"><?= $student['nama_lengkap'] ?></td>
                            <td style="text-align: center;">
                                <?php
                                $status = isset($existing_attendance[$student['id']]) ? $existing_attendance[$student['id']] : 'alfa';
                                ?>
                                <div class="attendance-options">
                                    <label class="radio-label presence">
                                        <input type="radio" name="status[<?= $student['id'] ?>]" value="hadir" <?= $status == 'hadir' ? 'checked' : '' ?> required>
                                        <span>H</span>
                                    </label>
                                    <label class="radio-label sick">
                                        <input type="radio" name="status[<?= $student['id'] ?>]" value="sakit" <?= $status == 'sakit' ? 'checked' : '' ?>>
                                        <span>S</span>
                                    </label>
                                    <label class="radio-label permit">
                                        <input type="radio" name="status[<?= $student['id'] ?>]" value="izin" <?= $status == 'izin' ? 'checked' : '' ?>>
                                        <span>I</span>
                                    </label>
                                    <label class="radio-label alpha">
                                        <input type="radio" name="status[<?= $student['id'] ?>]" value="alfa" <?= $status == 'alfa' ? 'checked' : '' ?>>
                                        <span>A</span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input type="text" name="keterangan[<?= $student['id'] ?>]" placeholder="Opsional" style="padding: 5px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px; width: 100%;">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div style="margin-top: 20px; text-align: right;">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 30px;">
                        <i class="fa-solid fa-save"></i> Simpan Absensi
                    </button>
                </div>
            </div>
        </form>
        <?php else: ?>
            <div class="card glass" style="text-align: center; padding: 40px;">
                <p>Tidak ada data siswa di kelas ini.</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
.attendance-options {
    display: flex;
    justify-content: center;
    gap: 10px;
}
.radio-label {
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    font-weight: bold;
    font-size: 0.8rem;
    position: relative;
    transition: all 0.2s;
}
.radio-label input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}
/* Active States */
.radio-label.presence:has(input:checked) { background: #10b981; color: #fff; box-shadow: 0 0 10px #10b981; }
.radio-label.sick:has(input:checked) { background: #f59e0b; color: #fff; box-shadow: 0 0 10px #f59e0b; }
.radio-label.permit:has(input:checked) { background: #3b82f6; color: #fff; box-shadow: 0 0 10px #3b82f6; }
.radio-label.alpha:has(input:checked) { background: #ef4444; color: #fff; box-shadow: 0 0 10px #ef4444; }

.radio-label:hover {
    background: rgba(255,255,255,0.2);
}
</style>

<script>
function setAll(status) {
    const radios = document.querySelectorAll(`input[value="${status}"]`);
    radios.forEach(radio => radio.checked = true);
}
</script>

<?php include '../includes/footer.php'; ?>
