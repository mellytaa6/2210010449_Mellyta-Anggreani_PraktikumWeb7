<div class="top-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 class="page-title" style="font-size: 1.8rem; font-weight: 700;">
        <?= isset($page_title) ? $page_title : 'School Gen Z' ?>
    </h1>

    <div class="user-profile" style="display: flex; align-items: center; gap: 20px;">
        <!-- Theme Toggle -->
        <button onclick="toggleThemeGlobal()"
            style="background: none; border: none; color: var(--text-muted); font-size: 1.2rem; cursor: pointer; transition: 0.3s;">
            <i class="fa-solid fa-moon" id="theme-icon"></i>
        </button>

        <!-- Notification Bell -->
        <a href="/praktikum7/notifications/idx.php"
            style="color: var(--text-muted); position: relative; transition: color 0.3s;">
            <i class="fa-regular fa-bell" style="font-size: 1.4rem;"></i>
            <?php
            // Count unread
            if (isset($_SESSION['user_id'])) {
                $uid_notif = $_SESSION['user_id'];
                $unread_count = 0;
                $res_notif = $conn->query("SELECT COUNT(*) FROM notifications WHERE user_id = $uid_notif AND is_read = 0");
                if ($res_notif) {
                    $unread_count = $res_notif->fetch_row()[0];
                }

                if ($unread_count > 0) {
                    echo '<span style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: #fff; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: bold; border: 2px solid var(--bg-dark);">' . ($unread_count > 9 ? '9+' : $unread_count) . '</span>';
                }
            }
            ?>
        </a>

        <!-- Divider -->
        <div style="width: 1px; height: 30px; background: var(--glass-border);"></div>

        <!-- User Info -->
        <div style="display: flex; align-items: center; gap: 12px;">
            <div class="text-right"
                style="text-align: right; display: none; @media (min-width: 768px) { display: block; }">
                <div style="font-weight: bold; font-size: 0.95rem;">
                    <?= isset($_SESSION['name']) ? $_SESSION['name'] : 'User' ?>
                </div>
                <div
                    style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                    <?= isset($_SESSION['role']) ? $_SESSION['role'] : 'Guest' ?>
                </div>
            </div>
            <div class="avatar"
                style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; color: white; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);">
                <?= isset($_SESSION['name']) ? substr($_SESSION['name'], 0, 1) : 'U' ?>
            </div>
        </div>
    </div>
</div>



<style>
    /* Hover effect for bell */
    .user-profile a:hover {
        color: var(--primary) !important;
    }

    /* Responsive adjustment (hide name on mobile) */
    @media (max-width: 768px) {
        .text-right {
            display: none !important;
        }
    }
</style>