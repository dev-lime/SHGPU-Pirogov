<?php
extract($config);
?>
<div id="<?= $entityType ?>-form" class="create-form" style="display: none;">
	<h3><?= htmlspecialchars($title) ?></h3>
	<form action="/tk/controllers/create_entity.php" method="POST">
		<input type="hidden" name="entity_type" value="<?= $entityType ?>">
		<?php foreach ($fields as $field): ?>
			<div class="form-group">
				<label><?= htmlspecialchars($field['label']) ?>:</label>
				<?php if ($field['type'] === 'select'): ?>
					<?= renderSelectElement(
						$field['name'],
						$field['options'] ?? null,
						$field['valueField'] ?? 'value',
						$field['displayField'] ?? 'display',
						null,
						$field['required'] ?? false
					) ?>
				<?php elseif ($field['type'] === 'textarea'): ?>
					<textarea name="<?= $field['name'] ?>"></textarea>
				<?php else: ?>
					<input type="<?= $field['type'] ?>" name="<?= $field['name'] ?>" <?= !empty($field['required']) ? 'required' : '' ?> 		<?= isset($field['min']) ? "min=\"{$field['min']}\"" : '' ?>>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<button type="submit" class="submit-btn">Создать</button>
		<button type="button" class="cancel-btn" onclick="toggleForm('<?= $entityType ?>-form')">Отмена</button>
	</form>
</div>