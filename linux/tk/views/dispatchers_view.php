<h2>Диспетчеры</h2>
<input type="hidden" name="entity_type" value="dispatchers">
<table>
	<thead>
		<tr>
			<th width="30px"><!--input type="checkbox" id="select-all"--></th>
			<th>ID</th>
			<th>ФИО</th>
			<th>Телефон</th>
			<th>Email</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($dispatchers as $dispatcher): ?>
			<tr id="dispatcher-<?= $dispatcher['dispatcher_id'] ?>">
				<td><input type="checkbox" name="ids[]" value="<?= $dispatcher['dispatcher_id'] ?>"></td>
				<td><?= htmlspecialchars($dispatcher['dispatcher_id']) ?></td>
				<td><?= htmlspecialchars($dispatcher['full_name']) ?></td>
				<td><?= htmlspecialchars($dispatcher['phone']) ?></td>
				<td><?= htmlspecialchars($dispatcher['email']) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="table-controls">
	<div class="controls-left">
		<button class="create-btn" onclick="toggleForm('dispatcher-form')">+ Создать</button>
		<button type="button" id="delete-selected" class="delete-btn" disabled>
			Удалить выбранные (<span class="selected-count">0</span>)
		</button>
	</div>
	<div class="controls-right">
		<p class="count">Всего записей: <?= count($dispatchers) ?></p>
	</div>
</div>

<div id="dispatcher-form" class="create-form" style="display: none;">
	<h3>Новый диспетчер</h3>
	<form action="/tk/controllers/create_entity.php" method="POST">
		<input type="hidden" name="entity_type" value="dispatcher">
		<div class="form-group">
			<label>ФИО:</label>
			<input type="text" name="full_name" required>
		</div>
		<div class="form-group">
			<label>Телефон:</label>
			<input type="text" name="phone">
		</div>
		<div class="form-group">
			<label>Email:</label>
			<input type="email" name="email">
		</div>
		<button type="submit" class="submit-btn">Создать</button>
		<button type="button" class="cancel-btn" onclick="toggleForm('dispatcher-form')">Отмена</button>
	</form>
</div>