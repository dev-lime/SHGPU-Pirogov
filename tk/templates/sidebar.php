<!-- Overlay для мобильной версии -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="sidebar">
    <!-- Кнопка сворачивания для десктопа -->
    <button class="sidebar-toggle-btn" onclick="toggleSidebarCompact()">
        <i class="fas fa-chevron-left"></i>
    </button>

    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-truck"></i>
            <h3>ТК Логистик</h3>
        </div>
    </div>

    <nav class="sidebar-nav">
        <!-- Основное -->
        <div class="nav-section">
            <h4>Основное</h4>
            <div class="nav-items">
                <a href="/tk/index.php"
                    class="nav-item <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
                    <i class="fas fa-chart-pie"></i>
                    <span>Дашборд</span>
                </a>
            </div>
        </div>

        <!-- Заказы -->
        <?php if (hasPermission('view_orders') || hasPermission('view_own_orders') || hasPermission('view_all')): ?>
            <div class="nav-section">
                <h4>Заказы</h4>
                <div class="nav-items">
                    <a href="/tk/modules/orders/index.php"
                        class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/orders/') !== false ? 'active' : '' ?>">
                        <i class="fas fa-list"></i>
                        <span>Все заказы</span>
                    </a>
                    <?php if (hasPermission('create_orders')): ?>
                        <a href="/tk/modules/orders/create.php"
                            class="nav-item <?= basename($_SERVER['PHP_SELF']) === 'create.php' ? 'active' : '' ?>">
                            <i class="fas fa-plus"></i>
                            <span>Создать заказ</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Клиенты -->
        <?php if (hasPermission('view_all')): ?>
            <div class="nav-section">
                <h4>Клиенты</h4>
                <div class="nav-items">
                    <a href="/tk/modules/clients/index.php"
                        class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/clients/') !== false ? 'active' : '' ?>">
                        <i class="fas fa-users"></i>
                        <span>Управление клиентами</span>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Водители и транспорт -->
        <?php if (hasPermission('view_all')): ?>
            <div class="nav-section">
                <h4>Персонал</h4>
                <div class="nav-items">
                    <a href="/tk/modules/drivers/index.php"
                        class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/drivers/') !== false ? 'active' : '' ?>">
                        <i class="fas fa-id-card"></i>
                        <span>Водители</span>
                    </a>
                    <a href="/tk/modules/vehicles/index.php"
                        class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/vehicles/') !== false ? 'active' : '' ?>">
                        <i class="fas fa-truck"></i>
                        <span>Транспорт</span>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Администрирование -->
        <?php if (getUserRole() === 'admin'): ?>
            <div class="nav-section">
                <h4>Администрирование</h4>
                <div class="nav-items">
                    <a href="/tk/modules/users/index.php"
                        class="nav-item <?= strpos($_SERVER['REQUEST_URI'], '/users/') !== false ? 'active' : '' ?>">
                        <i class="fas fa-user-cog"></i>
                        <span>Пользователи</span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </nav>
</div>