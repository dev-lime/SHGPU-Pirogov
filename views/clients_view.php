<h2>Клиенты</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Телефон</th>
            <th>Email</th>
            <th>Компания</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
        <tr>
            <td><?= htmlspecialchars($client['client_id']) ?></td>
            <td><?= htmlspecialchars($client['full_name']) ?></td>
            <td><?= htmlspecialchars($client['phone']) ?></td>
            <td><?= htmlspecialchars($client['email']) ?></td>
            <td><?= htmlspecialchars($client['company_name']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p class="count">Всего клиентов: <?= count($clients) ?></p>
