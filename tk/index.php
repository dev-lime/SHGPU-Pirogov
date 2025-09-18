<?php
require_once 'config/database.php';
require_once 'utils/auth.php';
require_once 'utils/dashboard_stats.php';

requireAuth();

$pageTitle = 'Дашборд - Транспортная компания';

// Получаем статистику для дашборда
$stats = getDashboardStats($_SESSION['user_id'], $_SESSION['role']);

require 'templates/header.php';
?>

<div class="dashboard">
	<div class="stats-grid">
		<div class="stat-card">
			<div class="stat-icon" style="background: #4CAF50;">
				<i class="fas fa-shipping-fast"></i>
			</div>
			<div class="stat-content">
				<h3><?= $stats['total_orders'] ?></h3>
				<p>Всего заказов</p>
			</div>
		</div>

		<div class="stat-card">
			<div class="stat-icon" style="background: #2196F3;">
				<i class="fas fa-truck-loading"></i>
			</div>
			<div class="stat-content">
				<h3><?= $stats['active_orders'] ?></h3>
				<p>Активные заказы</p>
			</div>
		</div>

		<div class="stat-card">
			<div class="stat-icon" style="background: #FF9800;">
				<i class="fas fa-check-circle"></i>
			</div>
			<div class="stat-content">
				<h3><?= $stats['completed_orders'] ?></h3>
				<p>Завершённые</p>
			</div>
		</div>

		<?php if (hasPermission('view_all')): ?>
			<div class="stat-card">
				<div class="stat-icon" style="background: #9C27B0;">
					<i class="fas fa-users"></i>
				</div>
				<div class="stat-content">
					<h3><?= $stats['total_clients'] ?></h3>
					<p>Клиенты</p>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<div class="dashboard-sections">
		<div class="recent-orders">
			<h3>Последние заказы</h3>
			<div class="table-responsive">
				<table class="data-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Клиент</th>
							<th>Направление</th>
							<th>Статус</th>
							<th>Дата</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($stats['recent_orders'] as $order): ?>
							<tr onclick="window.location='/tk/modules/orders/view.php?id=<?= $order['order_id'] ?>'"
								style="cursor: pointer;">
								<td>#<?= $order['order_id'] ?></td>
								<td><?= htmlspecialchars($order['client_name']) ?></td>
								<td><?= htmlspecialchars($order['origin']) ?> →
									<?= htmlspecialchars($order['destination']) ?></td>
								<td><span class="status-badge status-<?= $order['status'] ?>"><?= $order['status'] ?></span>
								</td>
								<td><?= date('d.m.Y', strtotime($order['created_at'])) ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="quick-actions">
			<h3>Быстрые действия</h3>
			<div class="action-buttons">
				<?php if (hasPermission('create_orders')): ?>
					<a href="/tk/modules/orders/create.php" class="action-btn">
						<i class="fas fa-plus"></i>
						<span>Создать заказ</span>
					</a>
				<?php endif; ?>

				<?php if (hasPermission('view_own_orders')): ?>
					<a href="/tk/modules/orders/index.php?filter=my" class="action-btn">
						<i class="fas fa-list"></i>
						<span>Мои заказы</span>
					</a>
				<?php endif; ?>

				<?php if (hasPermission('view_all')): ?>
					<a href="/tk/modules/clients/index.php" class="action-btn">
						<i class="fas fa-user-plus"></i>
						<span>Добавить клиента</span>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php require 'templates/footer.php'; ?>