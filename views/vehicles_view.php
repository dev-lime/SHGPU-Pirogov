<h2>Транспортные средства</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Гос. номер</th>
            <th>Модель</th>
            <th>Грузоподъемность (кг)</th>
            <th>Статус</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vehicles as $vehicle): ?>
        <tr>
            <td><?= htmlspecialchars($vehicle['vehicle_id']) ?></td>
            <td><?= htmlspecialchars($vehicle['plate_number']) ?></td>
            <td><?= htmlspecialchars($vehicle['model']) ?></td>
            <td><?= htmlspecialchars($vehicle['capacity_kg']) ?></td>
            <td><?= htmlspecialchars($vehicle['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p class="count">Всего транспортных средств: <?= count($vehicles) ?></p>
