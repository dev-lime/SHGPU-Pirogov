<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-truck"></i>
            <h3>ТК Логистик</h3>
        </div>
        <span class="user-role"><?= htmlspecialchars($_SESSION['role'] ?? 'Гость') ?></span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <h4>Основное</h4>
            <a href="/tk/index.php"
                class="nav-item <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Дашборд</span>
            </a>
        </div>

        <?php if (hasPermission('view_orders') || hasPermission('view_own_orders')): ?>
            <div class="nav-section">
                <h4>Заказы</h4>
                <a href="/tk/modules/orders/index.php"
                    class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/orders/') !== false ? 'active' : '' ?>">
                    <i class="fas fa-shipping-fast"></i>
                    <span>Все заказы</span>
                </a>

                <?php if (hasPermission('create_orders')): ?>
                    <a href="/tk/modules/orders/create.php" class="nav-item">
                        <i class="fas fa-plus"></i>
                        <span>Создать заказ</span>
                    </a>
                <?php endif; ?>

                <?php if (hasPermission('view_own_orders')): ?>
                    <a href="/tk/modules/orders/index.php?filter=my" class="nav-item">
                        <i class="fas fa-list"></i>
                        <span>Мои заказы</span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (hasPermission('view_all')): ?>
            <div class="nav-section">
                <h4>Справочники</h4>
                <a href="/tk/modules/clients/index.php"
                    class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/clients/') !== false ? 'active' : '' ?>">
                    <i class="fas fa-users"></i>
                    <span>Клиенты</span>
                </a>
                <a href="/tk/modules/drivers/index.php"
                    class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/drivers/') !== false ? 'active' : '' ?>">
                    <i class="fas fa-id-card"></i>
                    <span>Водители</span>
                </a>
                <a href="/tk/modules/dispatchers/index.php"
                    class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/dispatchers/') !== false ? 'active' : '' ?>">
                    <i class="fas fa-headset"></i>
                    <span>Диспетчеры</span>
                </a>
                <a href="/tk/modules/vehicles/index.php"
                    class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/vehicles/') !== false ? 'active' : '' ?>">
                    <i class="fas fa-truck"></i>
                    <span>Транспорт</span>
                </a>
            </div>
        <?php endif; ?>

        <?php if (getUserRole() === 'admin'): ?>
            <div class="nav-section">
                <h4>Администрирование</h4>
                <a href="/tk/modules/users/index.php"
                    class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/users/') !== false ? 'active' : '' ?>">
                    <i class="fas fa-user-cog"></i>
                    <span>Пользователи</span>
                </a>
                <a href="/tk/modules/reports/index.php" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Отчёты</span>
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