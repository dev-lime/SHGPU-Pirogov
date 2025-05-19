<?php
extract($config);
?>
<div class="table-filters">
	<form method="GET" action="">
		<?php foreach ($filterFields as $field => $options): ?>
			<div class="filter-group">
				<label for="<?= $entityType ?>_filter_<?= $field ?>"><?= $options['label'] ?>:</label>

				<?php if ($options['type'] === 'select'): ?>
					<select name="<?= $entityType ?>_filter[<?= $field ?>]" id="<?= $entityType ?>_filter_<?= $field ?>">
						<option value="">Все</option>
						<?php foreach ($options['values'] as $value => $label): ?>
							<option value="<?= htmlspecialchars($value) ?>" <?= (isset($_GET[$entityType . '_filter'][$field]) && $_GET[$entityType . '_filter'][$field] == $value) ? 'selected' : '' ?>>
								<?= htmlspecialchars($label) ?>
							</option>
						<?php endforeach; ?>
					</select>

				<?php elseif ($options['type'] === 'date_range'): ?>
					<div class="date-range-filter">
						<input type="date" name="<?= $entityType ?>_filter[<?= $field ?>][from]" placeholder="От"
							value="<?= htmlspecialchars($_GET[$entityType . '_filter'][$field]['from'] ?? '') ?>">
						<span class="date-range-separator">—</span>
						<input type="date" name="<?= $entityType ?>_filter[<?= $field ?>][to]" placeholder="До"
							value="<?= htmlspecialchars($_GET[$entityType . '_filter'][$field]['to'] ?? '') ?>">
					</div>

				<?php else: ?>
					<input type="<?= $options['type'] ?>" name="<?= $entityType ?>_filter[<?= $field ?>]"
						id="<?= $entityType ?>_filter_<?= $field ?>" placeholder="<?= $options['placeholder'] ?? '' ?>"
						value="<?= htmlspecialchars($_GET[$entityType . '_filter'][$field] ?? '') ?>">
				<?php endif; ?>
			</div>
		<?php endforeach; ?>

		<div class="filter-actions">
			<button type="submit" class="filter-btn">Применить</button>
			<button type="button" class="reset-btn" onclick="resetFilters('<?= $entityType ?>')">Сбросить</button>
		</div>

		<!-- Скрытые поля для сохранения других фильтров при отправке формы -->
		<?php foreach ($_GET as $key => $value): ?>
			<?php if (strpos($key, '_filter') === false && !in_array($key, ['success', 'error'])): ?>
				<?php if (is_array($value)): ?>
					<?php foreach ($value as $subkey => $subvalue): ?>
						<input type="hidden" name="<?= htmlspecialchars($key) ?>[<?= htmlspecialchars($subkey) ?>]"
							value="<?= htmlspecialchars($subvalue) ?>">
					<?php endforeach; ?>
				<?php else: ?>
					<input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</form>
</div>