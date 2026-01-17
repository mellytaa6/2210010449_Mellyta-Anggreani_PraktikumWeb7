<?php
session_start();
include '../config/database.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$classes = $conn->query("SELECT * FROM classes ORDER BY nama_kelas ASC");
?>

<div class="main-content">
    <?php
    $page_title = 'Manajemen Siswa';
    include '../includes/topbar.php';
    ?>

    <div class="card glass">
        <div
            style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 1rem; gap: 10px;">
            <div style="display: flex; gap: 10px; flex: 1; max-width: 600px;">
                <input type="text" id="search" placeholder="Cari Nama/NIS/NISN..." style="margin-bottom: 0;">
                <select id="class_filter" style="margin-bottom: 0; width: 200px;">
                    <option value="">Semua Kelas</option>
                    <?php while ($c = $classes->fetch_assoc()): ?>
                        <option value="<?= $c['id'] ?>"><?= $c['nama_kelas'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <a href="add.php" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Siswa
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>NIS / NISN</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>L/P</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="student-data">
                <!-- Data loaded via AJAX -->
                <tr>
                    <td colspan="7" style="text-align: center;">Memuat data...</td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div id="pagination" style="margin-top: 20px; display: flex; justify-content: center; gap: 5px;"></div>
    </div>
</div>

<script>
    let currentPage = 1;

    function fetchStudents(page = 1) {
        const search = document.getElementById('search').value; const classId = document.getElementById('class_filter').value; currentPage = page;
        fetch(`api_get_students.php?page=${page}&search=${search}&class_id=${classId}`).then(response => response.json()).then(data => { document.getElementById('student-data').innerHTML = data.html; renderPagination(data.pagination); });
    }

    function renderPagination(pagination) {
        const container = document.getElementById('pagination'); let html = ''; for (let i = 1; i <= pagination.total_pages; i++) { const activeClass = i === pagination.current_page ? 'background: var(--primary); color: white;' : 'background: rgba(255,255,255,0.1);'; html += `<button onclick="fetchStudents(${i})" style="${activeClass} border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin: 0 2px;">${i}</button>`; }
        container.innerHTML = html;
    }

    // Event Listeners    
    document.getElementById('search').addEventListener('keyup', () => fetchStudents(1));
    document.getElementById('class_filter').addEventListener('change', () => fetchStudents(1));

    // Initial Load    
    fetchStudents();
</script>

<?php include '../includes/footer.php'; ?>