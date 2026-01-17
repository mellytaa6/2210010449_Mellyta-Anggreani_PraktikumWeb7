<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Managemen Sekolah</title>
    <link rel="stylesheet" href="/praktikum7/assets/css/style.css">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme Init -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
</head>

<body>
    <script>
        function toggleThemeGlobal() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const next = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateIconsGlobal(next);
        }

        function updateIconsGlobal(theme) {
            // Update Topbar Icon
            const topIcon = document.getElementById('theme-icon');
            if (topIcon) {
                if (theme === 'light') {
                    topIcon.className = 'fa-solid fa-sun';
                    topIcon.style.color = '#f59e0b';
                } else {
                    topIcon.className = 'fa-solid fa-moon';
                    topIcon.style.color = 'var(--text-muted)';
                }
            }

            // Update Sidebar Icon
            const sideIcon = document.getElementById('sidebar-theme-icon');
            if (sideIcon) {
                if (theme === 'light') {
                    sideIcon.className = 'fa-solid fa-sun';
                    // sideIcon.style.color = '#f59e0b'; // Optional: keep sidebar text color
                } else {
                    sideIcon.className = 'fa-solid fa-moon';
                    // sideIcon.style.color = 'inherit';
                }
            }
        }

        // Run on load to set initial icons
        document.addEventListener('DOMContentLoaded', () => {
            const current = localStorage.getItem('theme') || 'dark';
            updateIconsGlobal(current);
        });
    </script>
    <div class="app-container">