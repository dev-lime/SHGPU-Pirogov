<h2>Клиенты</h2>
<form id="delete-form" action="/controllers/delete_entities.php" method="POST">
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
<button type="button" id="delete-selected" class="delete-btn" disabled>
    Удалить выбранные (0)
</button>
</form>
<p class="count">Всего клиентов: <?= count($clients) ?></p>

<button class="create-btn" onclick="toggleForm('client-form')">+ Добавить клиента</button>

<div id="client-form" class="create-form" style="display: none;">
    <h3>Новый клиент</h3>
    <form action="/controllers/create_client.php" method="POST">
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
