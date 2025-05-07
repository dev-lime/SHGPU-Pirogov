<h2>Водители</h2>
<input type="hidden" name="entity_type" value="drivers">
<table>
	<thead>
		<tr>
			<th width="30px"><!--input type="checkbox" id="select-all"--></th>
			<th>ID</th>
			<th>ФИО</th>
			<th>Номер лицензии</th>
			<th>Телефон</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($drivers as $driver): ?>
			<tr id="driver-<?= $driver['driver_id'] ?>">
				<td><input type="checkbox" name="ids[]" value="<?= $driver['driver_id'] ?>"></td>
				<td><?= htmlspecialchars($driver['driver_id']) ?></td>
				<td><?= htmlspecialchars($driver['full_name']) ?></td>
				<td><?= htmlspecialchars($driver['license_number']) ?></td>
				<td><?= htmlspecialchars($driver['phone']) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="table-controls">
	<div class="controls-left">
		<button class="create-btn" onclick="toggleForm('driver-form')">+ Создать</button>
		<button type="button" id="delete-selected" class="delete-btn" disabled>
			Удалить выбранные (<span class="selected-count">0</span>)
		</button>
	</div>
	<div class="controls-right">
		<p class="count">Всего записей: <?= count($drivers) ?></p>
	</div>
</div>

<div id="driver-form" class="create-form" style="display: none;">
	<h3>Новый водитель</h3>
	<form action="/tk/controllers/create_entity.php" method="POST">
		<input type="hidden" name="entity_type" value="driver">
		<div class="form-group">
			<label>ФИО:</label>
			<input type="text" name="full_name" required>
		</div>
		<div class="form-group">
			<label>Номер лицензии:</label>
			<input type="text" name="license_number" required>
		</div>
		<div class="form-group">
			<label>Телефон:</label>
			<input type="text" name="phone">
		</div>
		<button type="submit" class="submit-btn">Создать</button>
		<button type="button" class="cancel-btn" onclick="toggleForm('driver-form')">Отмена</button>
	</form>
</div>