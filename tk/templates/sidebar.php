<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-truck"></i>
            <h3>ТК Логистик</h3>
        </div>
        <span class="user-role"><?= htmlspecialchars($_SESSION['role'] ?? 'Гость') ?></span>
    </div>

    <nav class="sidebar-nav">
        <!-- Основное -->
        <div class="nav-section">
            <h4>Основное</h4>
            <a href="/tk/index.php"
                class="nav-item <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i> Дашборд
            </a>
        </div>

        <!-- Заказы -->
        <?php if (hasPermission('view_orders')): ?>
            <div class="nav-section">
                <h4>Заказы</h4>
                <a href="/tk/modules/orders/index.php" class="nav-item">
                    <i class="fas fa-list"></i> Все заказы
                </a>
                <a href="/tk/modules/orders/create.php" class="nav-item">
                    <i class="fas fa-plus"></i> Создать заказ
                </a>
            </div>
        <?php endif; ?>

        <!-- Справочники -->
        <?php if (hasPermission('view_all')): ?>
            <div class="nav-section">
                <h4>Справочники</h4>
                <a href="/tk/modules/clients/index.php" class="nav-item">
                    <i class="fas fa-users"></i> Клиенты
                </a>
                <a href="/tk/modules/dispatchers/index.php" class="nav-item">
                    <i class="fas fa-headset"></i> Диспетчеры
                </a>
                <a href="/tk/modules/drivers/index.php" class="nav-item">
                    <i class="fas fa-id-card"></i> Водители
                </a>
                <a href="/tk/modules/vehicles/index.php" class="nav-item">
                    <i class="fas fa-truck"></i> Транспорт
                </a>
            </div>
        <?php endif; ?>

        <!-- Отчеты -->
        <?php if (hasPermission('view_reports')): ?>
            <div class="nav-section">
                <h4>Аналитика</h4>
                <a href="/tk/modules/reports/index.php" class="nav-item">
                    <i class="fas fa-chart-bar"></i> Отчеты
                </a>
            </div>
        <?php endif; ?>

        <!-- Администрирование -->
        <?php if (getUserRole() === 'admin'): ?>
            <div class="nav-section">
                <h4>Администрирование</h4>
                <a href="/tk/modules/users/index.php" class="nav-item">
                    <i class="fas fa-user-cog"></i> Пользователи
                </a>
            </div>
        <?php endif; ?>
    </nav>

    <div class="sidebar-footer">
        <div class="system-info">
            <small>Версия 1.0.0</small>
            <small><?= date('Y') ?> © ТК Логистик</small>
        </div>
    </div>
</div>