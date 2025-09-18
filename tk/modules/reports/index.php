<?php
require_once '../../config/database.php';
require_once '../../utils/auth.php';

requireAuth();
requirePermission('view_reports');

$pageTitle = 'Отчеты';
$startDate = $_GET['start_date'] ?? date('Y-m-01');
$endDate = $_GET['end_date'] ?? date('Y-m-t');

require '../../templates/header.php';

// Получаем статистику для отчетов
$con = getDBConnection();
$reports = getReportsData($startDate, $endDate);
?>

<div class="page-header">
    <h1>Отчеты</h1>
</div>

<div class="ios-card">
    <h3>Период отчета</h3>
    <form method="GET" class="report-form">
        <div class="form-row">
            <div class="form-group">
                <label>С:</label>
                <input type="date" name="start_date" value="<?= $startDate ?>" class="form-control">
            </div>
            <div class="form-group">
                <label>По:</label>
                <input type="date" name="end_date" value="<?= $endDate ?>" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Применить
                </button>
            </div>
        </div>
    </form>
</div>

<div class="stats-grid">
    <div class="ios-card">
        <h3>Общая статистика</h3>
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--ios-primary);">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <div class="stat-content">
                <h3><?= $reports['total_orders'] ?></h3>
                <p>Всего заказов</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--ios-green);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3><?= $reports['completed_orders'] ?></h3>
                <p>Завершено</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--ios-orange);">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <h3><?= number_format($reports['total_revenue'], 2) ?> ₽</h3>
                <p>Общая выручка</p>
            </div>
        </div>
    </div>

    <div class="ios-card">
        <h3>Статистика по водителям</h3>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Водитель</th>
                        <th>Заказов</th>
                        <th>Выручка</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports['driver_stats'] as $stat): ?>
                        <tr>
                            <td><?= htmlspecialchars($stat['driver_name']) ?></td>
                            <td><?= $stat['order_count'] ?></td>
                            <td><?= number_format($stat['revenue'], 2) ?> ₽</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="ios-card">
    <h3>График заказов по дням</h3>
    <div id="ordersChart" style="height: 300px;"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_keys($reports['daily_orders'])) ?>,
            datasets: [{
                label: 'Заказов в день',
                data: <?= json_encode(array_values($reports['daily_orders'])) ?>,
                borderColor: '#007AFF',
                tension: 0.1
            }]
        }
    });
</script>

<?php
function getReportsData($startDate, $endDate)
{
    $con = getDBConnection();

    $data = [
        'total_orders' => 0,
        'completed_orders' => 0,
        'total_revenue' => 0,
        'driver_stats' => [],
        'daily_orders' => []
    ];

    // Здесь реализуйте запросы к базе данных для получения статистики
    // Это примерные запросы - адаптируйте под вашу структуру БД

    return $data;
}

require '../../templates/footer.php';
?>