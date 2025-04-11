<h2>Диспетчеры</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Телефон</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dispatchers as $dispatcher): ?>
        <tr>
            <td><?= htmlspecialchars($dispatcher['dispatcher_id']) ?></td>
            <td><?= htmlspecialchars($dispatcher['full_name']) ?></td>
            <td><?= htmlspecialchars($dispatcher['phone']) ?></td>
            <td><?= htmlspecialchars($dispatcher['email']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p class="count">Всего диспетчеров: <?= count($dispatchers) ?></p>

<button class="create-btn" onclick="toggleForm('dispatcher-form')">+ Добавить диспетчера</button>

<div id="dispatcher-form" class="create-form" style="display: none;">
    <h3>Новый диспетчер</h3>
    <form action="/controllers/create_dispatcher.php" method="POST">
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
