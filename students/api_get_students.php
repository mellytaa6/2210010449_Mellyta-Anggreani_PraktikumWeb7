<?php
include '../config/database.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';

$where = "WHERE 1=1";
if ($search) {
    $where .= " AND (students.nama_lengkap LIKE '%$search%' OR students.nis LIKE '%$search%' OR students.nisn LIKE '%$search%')";
}
if ($class_id) {
    $where .= " AND students.kelas_id = $class_id";
}

// Count Total
$total_sql = "SELECT COUNT(*) as c FROM students $where";
$total_rows = $conn->query($total_sql)->fetch_assoc()['c'];
$total_pages = ceil($total_rows / $limit);

// Fetch Data
$sql = "SELECT students.*, classes.nama_kelas 
        FROM students 
        LEFT JOIN classes ON students.kelas_id = classes.id 
        $where 
        ORDER BY students.nama_lengkap ASC 
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$html = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $photo_src = $row['foto'] ? "../assets/uploads/" . $row['foto'] : '';
        $avatar = substr($row['nama_lengkap'], 0, 1);

        $img_html = $photo_src
            ? "<img src='$photo_src' style='width: 40px; height: 40px; border-radius: 50%; object-fit: cover;'>"
            : "<div class='avatar' style='width: 40px; height: 40px; font-size: 0.8rem;'>$avatar</div>";

        $class_badge = $row['nama_kelas']
            ? "<span style='background: rgba(139, 92, 246, 0.2); color: #c4b5fd; padding: 4px 10px; border-radius: 8px; font-size: 0.8rem;'>{$row['nama_kelas']}</span>"
            : "<span style='color:red'>-</span>";

        $gender = $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan';

        // Status Badge
        $status_color = '#10b981'; // aktif
        if ($row['status'] == 'alumni')
            $status_color = '#3b82f6';
        elseif ($row['status'] == 'pindah')
            $status_color = '#f59e0b';
        elseif ($row['status'] == 'keluar')
            $status_color = '#ef4444';

        $status_badge = "<span style='color: $status_color; text-transform: capitalize;'>{$row['status']}</span>";

        $html .= "
        <tr>
            <td>$img_html</td>
            <td>
                <div>{$row['nis']}</div>
                <small style='color: var(--text-muted);'>{$row['nisn']}</small>
            </td>
            <td>{$row['nama_lengkap']}</td>
            <td>$class_badge</td>
            <td>$gender</td>
            <td>$status_badge</td>
            <td>
                <a href='edit.php?id={$row['id']}' style='color: var(--accent); margin-right: 10px;'><i class='fa-solid fa-pen-to-square'></i></a>
                <a href='delete.php?id={$row['id']}' style='color: #ef4444;' onclick=\"return confirm('Yakin hapus?')\"><i class='fa-solid fa-trash'></i></a>
            </td>
        </tr>";
    }
} else {
    $html = "<tr><td colspan='7' style='text-align: center;'>Tidak ada data siswa ditemukan</td></tr>";
}

echo json_encode([
    'html' => $html,
    'pagination' => [
        'current_page' => $page,
        'total_pages' => $total_pages
    ]
]);
?>