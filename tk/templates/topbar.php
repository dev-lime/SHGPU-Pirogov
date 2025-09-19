<div class="topbar">
    <div class="topbar-left">
        <button class="mobile-sidebar-toggle" onclick="toggleMobileSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="topbar-title"><?= $pageTitle ?? 'Дашборд' ?></h1>
    </div>

    <div class="topbar-right">
        <div class="user-menu">
            <span class="user-info">
                <i class="fas fa-user"></i>
                <?= htmlspecialchars($_SESSION['username'] ?? 'Гость') ?>
                <small>(<?= htmlspecialchars($_SESSION['role'] ?? 'неавторизован') ?>)</small>
            </span>
            <div class="dropdown">
                <!--<a href="/tk/profile.php" class="dropdown-item">
                    <i class="fas fa-user-cog"></i> Профиль
                </a>-->
                <a href="/tk/logout.php" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i> Выйти
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.body.classList.toggle('sidebar-collapsed');
    }

    // Закрытие dropdown при клике вне его
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.user-menu')) {
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
        }
    });

    document.querySelector('.user-info').addEventListener('click', function (e) {
        e.stopPropagation();
        const dropdown = this.nextElementSibling;
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });
</script>