<?php
/**
 * @var string $title
 * @var string $entityType
 * @var string $primaryKey
 * @var array $items
 * @var array $columns
 */
extract($config);
if (!isset($items) || !is_array($items)) {
	$items = [];
}
?>
<h2><?= htmlspecialchars($title ?? '') ?></h2>
<div class="table-wrapper">
	<table>
		<thead>
			<tr>
				<th width="30px"><input type="checkbox" class="select-all"></th>
				<?php foreach ($columns ?? [] as $column): ?>
					<th><?= htmlspecialchars($column['label'] ?? '') ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($items as $item): ?>
				<tr id="<?= $entityType ?? '' ?>-<?= $item[$primaryKey ?? ''] ?? '' ?>">
					<td><input type="checkbox" class="row-checkbox" value="<?= $item[$primaryKey ?? ''] ?? '' ?>"></td>
					<?php foreach ($columns ?? [] as $column): ?>
						<td>
							<?php if (isset($column['type']) && $column['type'] === 'custom'): ?>
								<?= $column['render']($item) ?>
							<?php elseif (isset($column['link']) && isset(${$column['link']['entities']})): ?>
								<?= renderEntityLink(
									$item[$column['field']] ?? null,
									${$column['link']['entities']},
									$column['link']['idField'] ?? '',
									$column['link']['nameField'] ?? '',
									$column['link']['entityType'] ?? ''
								) ?>
							<?php else: ?>
								<?= htmlspecialchars($item[$column['field'] ?? ''] ?? '') ?>
							<?php endif; ?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="table-controls">
		<div class="controls-left">
			<?php
			// Проверяем права перед отображением кнопок
			if (hasPermission('create_all')): ?>
				<button class="create-btn" onclick="toggleForm('<?= $entityType ?? '' ?>-form')">+ Создать</button>
			<?php endif; ?>

			<?php if (hasPermission('delete_all')): ?>
				<button type="button" class="delete-btn" disabled>
					Удалить выбранные (<span class="selected-count">0</span>)
				</button>
			<?php endif; ?>
		</div>
		<div class="controls-right">
			<p class="count">Всего записей: <?= count($items) ?></p>
		</div>
	</div>
</div>
<input type="hidden" name="entity_type" value="<?= $entityType ?>">