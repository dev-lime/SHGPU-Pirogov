<nav class="main-nav">
	<ul>
		<?php if (hasPermission('view_all')): ?>
			<li><a href="#clients">Клиенты</a></li>
			<li><a href="#dispatchers">Диспетчеры</a></li>
			<li><a href="#drivers">Водители</a></li>
			<li><a href="#vehicles">Транспорт</a></li>
		<?php endif; ?>

		<?php if (hasPermission('view_orders') || hasPermission('view_own_orders')): ?>
			<li><a href="#orders">Заказы</a></li>
		<?php endif; ?>

		<?php if (getUserRole() === 'admin'): ?>
			<li><a href="#users">Пользователи</a></li>
		<?php endif; ?>

		<li style="float:right">
			<a href="/tk/logout.php">Выход (<?= htmlspecialchars($_SESSION['username'] ?? '') ?>)</a>
		</li>
	</ul>
</nav>