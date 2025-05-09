<h2>Клиенты</h2>
<input type="hidden" name="entity_type" value="clients">
<table>
	<thead>
		<tr>
			<th width="30px"><!--input type="checkbox" id="select-all"--></th>
			<th>ID</th>
			<th>ФИО</th>
			<th>Телефон</th>
			<th>Email</th>
			<th>Компания</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($clients as $client): ?>
			<tr id="client-<?= $client['client_id'] ?>">
				<td><input type="checkbox" name="ids[]" value="<?= $client['client_id'] ?>"></td>
				<td><?= htmlspecialchars($client['client_id']) ?></td>
				<td><?= htmlspecialchars($client['full_name']) ?></td>
				<td><?= htmlspecialchars($client['phone']) ?></td>
				<td><?= htmlspecialchars($client['email']) ?></td>
				<td><?= htmlspecialchars($client['company_name']) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="table-controls">
	<div class="controls-left">
		<button class="create-btn" onclick="toggleForm('client-form')">+ Создать</button>
		<button type="button" id="delete-selected" class="delete-btn" disabled>
			Удалить выбранные (<span class="selected-count">0</span>)
		</button>
	</div>
	<div class="controls-right">
		<p class="count">Всего записей: <?= count($clients) ?></p>
	</div>
</div>

<div id="client-form" class="create-form" style="display: none;">
	<h3>Новый клиент</h3>
	<form action="/tk/controllers/create_entity.php" method="POST">
		<input type="hidden" name="entity_type" value="client">
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
		<div class="form-group">
			<label>Компания:</label>
			<input type="text" name="company_name">
		</div>
		<button type="submit" class="submit-btn">Создать</button>
		<button type="button" class="cancel-btn" onclick="toggleForm('client-form')">Отмена</button>
	</form>
</div>