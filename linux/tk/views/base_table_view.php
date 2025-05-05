<?php
function renderTable($items, $columns, $entityType) {
    $primaryKey = $entityType . '_id';
    ?>
    <h2><?= ucfirst($entityType) ?></h2>
    <input type="hidden" name="entity_type" value="<?= $entityType ?>">
    <table>
        <thead>
            <tr>
                <th width="30px"></th>
                <?php foreach ($columns as $col): ?>
                <th><?= $col['title'] ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr id="<?= $entityType ?>-<?= $item[$primaryKey] ?>">
                <td><input type="checkbox" name="ids[]" value="<?= $item[$primaryKey] ?>"></td>
                <?php foreach ($columns as $col): ?>
                <td><?= htmlspecialchars($item[$col['field']] ?? '') ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="table-controls">
        <div class="controls-left">
            <button class="create-btn" onclick="toggleForm('<?= $entityType ?>-form')">+ Создать</button>
            <button type="button" id="delete-selected" class="delete-btn" disabled>
                Удалить выбранные (<span class="selected-count">0</span>)
            </button>
        </div>
        <div class="controls-right">
            <p class="count">Всего записей: <?= count($items) ?></p>
        </div>
    </div>
    <?php
}

function renderCreateForm($fields, $action) {
    ?>
    <div class="create-form" style="display: none;">
        <h3>Новый элемент</h3>
        <form action="<?= $action ?>" method="POST">
            <?php foreach ($fields as $field): ?>
            <div class="form-group">
                <label><?= $field['label'] ?>:</label>
                <?php if ($field['type'] === 'select'): ?>
                <select name="<?= $field['name'] ?>" <?= $field['required'] ? 'required' : '' ?>>
                    <?php foreach ($field['options'] as $option): ?>
                    <option value="<?= $option['value'] ?>"><?= $option['text'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php else: ?>
                <input type="<?= $field['type'] ?>" name="<?= $field['name'] ?>" <?= $field['required'] ? 'required' : '' ?>>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <button type="submit" class="submit-btn">Создать</button>
            <button type="button" class="cancel-btn" onclick="toggleForm('<?= $entityType ?>-form')">Отмена</button>
        </form>
    </div>
    <?php
}
?>
