<h2>Заказы</h2>
<input type="hidden" name="entity_type" value="orders">
<table>
	<thead>
		<tr>
			<th width="30px"><!--input type="checkbox" id="select-all"--></th>
			<th>ID</th>
			<th>Клиент</th>
			<th>Диспетчер</th>
			<th>Водитель</th>
			<th>Транспорт</th>
			<th>Откуда</th>
			<th>Куда</th>
			<th>Груз</th>
			<th>Вес (кг)</th>
			<th>Статус</th>
			<th>Дата создания</th>
			<th>Дата доставки</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($orders as $order): ?>
			<tr id="order-<?= $order['order_id'] ?>">
				<td><input type="checkbox" name="ids[]" value="<?= $order['order_id'] ?>"></td>
				<td><?= htmlspecialchars($order['order_id']) ?></td>
				<td><?= renderEntityLink($order['client_id'], $clients, 'client_id', 'full_name', 'client') ?></td>
				<td><?= renderEntityLink($order['dispatcher_id'], $dispatchers, 'dispatcher_id', 'full_name', 'dispatcher') ?>
				</td>
				<td><?= renderEntityLink($order['driver_id'], $drivers, 'driver_id', 'full_name', 'driver') ?></td>
				<td><?= renderEntityLink($order['vehicle_id'], $vehicles, 'vehicle_id', 'plate_number', 'vehicle') ?></td>
				<td><?= htmlspecialchars($order['origin']) ?></td>
				<td><?= htmlspecialchars($order['destination']) ?></td>
				<td><?= htmlspecialchars($order['cargo_description']) ?></td>
				<td><?= htmlspecialchars($order['weight_kg']) ?></td>
				<td><?= htmlspecialchars($order['status']) ?></td>
				<td><?= htmlspecialchars($order['created_at']) ?></td>
				<td><?= htmlspecialchars($order['delivery_date']) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="table-controls">
	<div class="controls-left">
		<button class="create-btn" onclick="toggleForm('order-form')">+ Создать</button>
		<button type="button" id="delete-selected" class="delete-btn" disabled>
			Удалить выбранные (<span class="selected-count">0</span>)
		</button>
	</div>
	<div class="controls-right">
		<p class="count">Всего записей: <?= count($orders) ?></p>
	</div>
</div>

<div id="order-form" class="create-form" style="display: none;">
	<h3>Новый заказ</h3>
	<form action="/tk/controllers/create_entity.php" method="POST">
		<input type="hidden" name="entity_type" value="order">
		<div class="form-group">
			<label>Клиент:</label>
			<select name="client_id" required>
				<?php foreach ($clients as $client): ?>
					<option value="<?= $client['client_id'] ?>">
						<?= htmlspecialchars($client['full_name']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-group">
			<label>Диспетчер:</label>
			<select name="dispatcher_id">
				<?php foreach ($dispatchers as $dispatcher): ?>
					<option value="<?= $dispatcher['dispatcher_id'] ?>">
						<?= htmlspecialchars($dispatcher['full_name']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-group">
			<label>Водитель:</label>
			<select name="driver_id">
				<?php foreach ($drivers as $driver): ?>
					<option value="<?= $driver['driver_id'] ?>">
						<?= htmlspecialchars($driver['full_name']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-group">
			<label>Транспорт:</label>
			<select name="vehicle_id">
				<?php foreach ($vehicles as $vehicle): ?>
					<option value="<?= $vehicle['vehicle_id'] ?>">
						<?= htmlspecialchars($vehicle['plate_number']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-group">
			<label>Откуда:</label>
			<input type="text" name="origin" required>
		</div>
		<div class="form-group">
			<label>Куда:</label>
			<input type="text" name="destination" required>
		</div>
		<div class="form-group">
			<label>Описание груза:</label>
			<textarea name="cargo_description"></textarea>
		</div>
		<div class="form-group">
			<label>Вес (кг):</label>
			<input type="number" name="weight_kg" min="1">
		</div>
		<div class="form-group">
			<label>Дата доставки:</label>
			<input type="date" name="delivery_date">
		</div>
		<button type="submit" class="submit-btn">Создать</button>
		<button type="button" class="cancel-btn" onclick="toggleForm('order-form')">Отмена</button>
	</form>
</div>