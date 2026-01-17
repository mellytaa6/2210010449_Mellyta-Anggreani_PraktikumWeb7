<?php
// Ensure session is started in main files
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar glass">
    <div class="brand">
        <i class="fa-solid fa-school"></i> MANAGEMEN SEKOLAH
    </div>

    <nav>
        <ul>
            <li>
                <a href="/praktikum7/dashboard.php"
                    class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
            </li>

            <li
                style="margin-top: 10px; font-size: 0.8rem; color: var(--text-muted); padding-left: 16px; text-transform: uppercase;">
                Akademik</li>

            <li>
                <a href="/praktikum7/students/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'students') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-graduate"></i> Siswa
                </a>
            </li>
            <li>
                <a href="/praktikum7/teachers/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'teachers') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-chalkboard-user"></i> Guru
                </a>
            </li>
            <li>
                <a href="/praktikum7/classes/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'classes') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-school"></i> Kelas
                </a>
            </li>
            <li>
                <a href="/praktikum7/subjects/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'subjects') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-book-open"></i> Mapel
                </a>
            </li>
            <!-- Master Data Section -->
            <li class="nav-item-header"
                style="margin-top: 20px; color: var(--text-muted); font-size: 0.8rem; padding-left: 20px; text-transform: uppercase;">
                Master Data
            </li>
            <li>
                <a href="/praktikum7/lesson_hours/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'lesson_hours') !== false ? 'active' : '' ?>">
                    <i class="fa-regular fa-clock"></i> Jam Pelajaran
                </a>
            </li>
            <li>
                <a href="/praktikum7/point_categories/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'point_categories') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-list"></i> Kategori Poin
                </a>
            </li>
            <li>
                <a href="/praktikum7/semesters/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'semesters') !== false ? 'active' : '' ?>">
                    <i class="fa-regular fa-calendar-alt"></i> Semester
                </a>
            </li>
            <li>
                <a href="/praktikum7/schedules/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'schedules') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-calendar-days"></i> Jadwal
                </a>
            </li>

            <li
                style="margin-top: 10px; font-size: 0.8rem; color: var(--text-muted); padding-left: 16px; text-transform: uppercase;">
                Perilaku</li>

            <li>
                <a href="/praktikum7/attendance/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'attendance') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-clipboard-user"></i> Absensi
                </a>
            </li>
            <li>
                <a href="/praktikum7/achievements/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'achievements') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-trophy"></i> Prestasi
                </a>
            </li>
            <li>
                <a href="/praktikum7/points/idx.php"
                    class="nav-link <?= strpos($_SERVER['REQUEST_URI'], 'points') !== false ? 'active' : '' ?>">
                    <i class="fa-solid fa-star"></i> Poin Pelanggaran
                </a>
            </li>

            <li style="margin-top: 2rem;">
                <a href="#" onclick="toggleThemeGlobal(); return false;" class="nav-link">
                    <i class="fa-solid fa-moon" id="sidebar-theme-icon"></i> Switch Theme
                </a>
            </li>
            <li>
                <a href="/praktikum7/logout.php" class="nav-link" style="color: #ef4444;">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
</aside>