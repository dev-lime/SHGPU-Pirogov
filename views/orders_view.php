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
