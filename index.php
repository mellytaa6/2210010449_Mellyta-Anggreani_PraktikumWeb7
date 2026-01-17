<?php
session_start();
include 'config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // For testing, if password hash matches OR if it's the demo logic
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['nama_lengkap'];

            // Update Last Login
            $conn->query("UPDATE users SET last_login = NOW() WHERE id = " . $user['id']);

            // Log Activity
            include 'includes/functions.php';
            logActivity($conn, $user['id'], 'LOGIN', 'User logged in');

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Managemen Sekolah</title>
    <link rel="stylesheet" href="/praktikum7/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
</head>

<body>
    <div class="login-container" style="position: relative;">
        <!-- Theme Toggle -->
        <button onclick="toggleThemeLogin()"
            style="position: absolute; top: 20px; right: 20px; background: none; border: none; color: var(--text-muted); font-size: 1.5rem; cursor: pointer; z-index: 10;">
            <i class="fa-solid fa-moon" id="login-theme-icon"></i>
        </button>
        <div class="login-box glass card">
            <h2 style="text-align: center; margin-bottom: 2rem; color: var(--primary);">WELCOME BACK! 👋</h2>

            <?php if ($error): ?>
                <div
                    style="background: rgba(239, 68, 68, 0.2); color: #ef4444; padding: 10px; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 8px; color: var(--text-muted);">Username</label>
                    <input type="text" name="username" placeholder="Enter username" required>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 8px; color: var(--text-muted);">Password</label>
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    LOGIN <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.9rem;">
                Default: admin / password
            </p>
        </div>
    </div>
    <script>
        function toggleThemeLogin() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const next = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateLoginIcon(next);
        }

        function updateLoginIcon(theme) {
            const icon = document.getElementById('login-theme-icon');
            if (theme === 'light') {
                icon.className = 'fa-solid fa-sun';
                icon.style.color = '#f59e0b';
            } else {
                icon.className = 'fa-solid fa-moon';
                icon.style.color = 'var(--text-muted)';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const current = localStorage.getItem('theme') || 'dark';
            updateLoginIcon(current);
        });
    </script>
</body>

</html>