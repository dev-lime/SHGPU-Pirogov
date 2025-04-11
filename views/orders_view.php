<h2>Заказы</h2>
<table>
    <thead>
        <tr>
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
        <tr>
            <td><?= htmlspecialchars($order['order_id']) ?></td>
            <td><?= htmlspecialchars($order['client_id']) ?></td>
            <td><?= htmlspecialchars($order['dispatcher_id']) ?></td>
            <td><?= htmlspecialchars($order['driver_id']) ?></td>
            <td><?= htmlspecialchars($order['vehicle_id']) ?></td>
            <td><?= htmlspecialchars($order['origin']) ?></td>
            <td><?= htmlspecialchars($order['destination']) ?></td>
            <td><?= htmlspecialchars(mb_substr($order['cargo_description'], 0, 30)) ?>...</td>
            <td><?= htmlspecialchars($order['weight_kg']) ?></td>
            <td><?= htmlspecialchars($order['status']) ?></td>
            <td><?= htmlspecialchars($order['created_at']) ?></td>
            <td><?= htmlspecialchars($order['delivery_date']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p class="count">Всего заказов: <?= count($orders) ?></p>

<button class="create-btn" onclick="toggleForm('order-form')">+ Добавить заказ</button>

<div id="order-form" class="create-form" style="display: none;">
    <h3>Новый заказ</h3>
    <form action="/controllers/create_order.php" method="POST">
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
        
        <!-- Аналогичные селекты для driver_id и vehicle_id -->
        
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
