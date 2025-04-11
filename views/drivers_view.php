<h2>Водители</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Номер лицензии</th>
            <th>Телефон</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($drivers as $driver): ?>
        <tr>
            <td><?= htmlspecialchars($driver['driver_id']) ?></td>
            <td><?= htmlspecialchars($driver['full_name']) ?></td>
            <td><?= htmlspecialchars($driver['license_number']) ?></td>
            <td><?= htmlspecialchars($driver['phone']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p class="count">Всего водителей: <?= count($drivers) ?></

<button class="create-btn" onclick="toggleForm('driver-form')">+ Добавить водителя</button>

<div id="driver-form" class="create-form" style="display: none;">
    <h3>Новый водитель</h3>
    <form action="/controllers/create_driver.php" method="POST">
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
