<h2>Транспортные средства</h2>
<form id="delete-form" action="/controllers/delete_entities.php" method="POST">
    <input type="hidden" name="entity_type" value="vehicles">
    <table>
        <thead>
            <tr>
                <th width="30px"><!--input type="checkbox" id="select-all"--></th>
                <th>ID</th>
                <th>Гос. номер</th>
                <th>Модель</th>
                <th>Грузоподъемность (кг)</th>
                <th>Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicles as $vehicle): ?>
                <tr id="vehicle-<?= $vehicle['vehicle_id'] ?>">
                    <td><input type="checkbox" name="ids[]" value="<?= $vehicle['vehicle_id'] ?>"></td>
                    <td><?= htmlspecialchars($vehicle['vehicle_id']) ?></td>
                    <td><?= htmlspecialchars($vehicle['plate_number']) ?></td>
                    <td><?= htmlspecialchars($vehicle['model']) ?></td>
                    <td><?= htmlspecialchars($vehicle['capacity_kg']) ?></td>
                    <td><?= htmlspecialchars($vehicle['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="table-controls">
        <div class="controls-left">
            <button class="create-btn" onclick="toggleForm('vehicle-form')">+ Создать</button>
            <button type="button" id="delete-selected" class="delete-btn" disabled>
                Удалить выбранные (<span class="selected-count">0</span>)
            </button>
        </div>
        <div class="controls-right">
            <p class="count">Всего записей: <?= count($vehicles) ?></p>
        </div>
    </div>

    <div id="vehicle-form" class="create-form" style="display: none;">
        <h3>Новое транспортное средство</h3>
        <form action="/controllers/create_vehicle.php" method="POST">
            <div class="form-group">
                <label>Гос. номер:</label>
                <input type="text" name="plate_number" required>
            </div>
            <div class="form-group">
                <label>Модель:</label>
                <input type="text" name="model">
            </div>
            <div class="form-group">
                <label>Грузоподъемность (кг):</label>
                <input type="number" name="capacity_kg" min="1">
            </div>
            <div class="form-group">
                <label>Статус:</label>
                <select name="status">
                    <option value="available">Доступен</option>
                    <option value="in_transit">В рейсе</option>
                    <option value="maintenance">На обслуживании</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">Создать</button>
            <button type="button" class="cancel-btn" onclick="toggleForm('vehicle-form')">Отмена</button>
        </form>
    </div>