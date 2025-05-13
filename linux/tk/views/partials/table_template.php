<?php
/**
 * @var string $title
 * @var string $entityType
 * @var string $primaryKey
 * @var array $items
 * @var array $columns
 */
extract($config); // Извлекаем переменные из конфигурационного массива
?>
<h2><?= htmlspecialchars($title) ?></h2>
<input type="hidden" name="entity_type" value="<?= $entityType ?>">
<table>
	<thead>
		<tr>
			<th width="30px"><!--input type="checkbox" id="select-all"--></th>
			<?php foreach ($columns as $column): ?>
				<th><?= htmlspecialchars($column['label']) ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($items as $item): ?>
			<tr id="<?= $entityType ?>-<?= $item[$primaryKey] ?>">
				<td><input type="checkbox" name="ids[]" value="<?= $item[$primaryKey] ?>"></td>
				<?php foreach ($columns as $column): ?>
					<td>
						<?php if (isset($column['link'])): ?>
							<?= renderEntityLink(
								$item[$column['field']],
								${$column['link']['entities']},
								$column['link']['idField'],
								$column['link']['nameField'],
								$column['link']['entityType']
							) ?>
						<?php else: ?>
							<?= htmlspecialchars($item[$column['field']] ?? '') ?>
						<?php endif; ?>
					</td>
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