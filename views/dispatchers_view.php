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
