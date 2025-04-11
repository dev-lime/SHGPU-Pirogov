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
