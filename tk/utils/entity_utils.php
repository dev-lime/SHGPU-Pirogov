<?php
/**
 * Получает название сущности по ID
 * 
 * @param mixed $entityId ID сущности
 * @param array $entities Массив всех сущностей данного типа
 * @param string $idField Название поля с ID
 * @param string $nameField Название поля с именем
 * @return string Название сущности или "Неизвестная запись"
 */
function getEntityName($entityId, array $entities, string $idField, string $nameField): string
{
	if (!$entityId) {
		return 'Не указан';
	}

	foreach ($entities as $entity) {
		if ($entity[$idField] == $entityId) {
			return htmlspecialchars($entity[$nameField] ?? 'Без названия');
		}
	}

	return "Неизвестная запись (ID: $entityId)";
}

/**
 * Генерирует HTML-ссылку на сущность
 * 
 * @param mixed $entityId ID сущности
 * @param array $entities Массив всех сущностей данного типа
 * @param string $idField Название поля с ID
 * @param string $nameField Название поля с именем
 * @param string $entityType Тип сущности (client, driver и т.д.)
 * @return string HTML-код ссылки или 'Не указан'
 */
function renderEntityLink($entityId, array $entities, string $idField, string $nameField, string $entityType): string
{
	if (!$entityId) {
		return 'Не указан';
	}

	$name = getEntityName($entityId, $entities, $idField, $nameField);
	return sprintf(
		'<a href="#%s-%d" class="entity-link">%s</a>',
		$entityType,
		$entityId,
		$name
	);
}

/**
 * Рендерит select-элемент для формы
 */
function renderSelectElement(
	string $name,
	?array $options,
	string $valueField,
	string $displayField,
	$selectedValue = null,
	bool $required = false
): string {
	if (!is_array($options)) {
		return '<select name="' . htmlspecialchars($name) . '"' . ($required ? ' required' : '') . '>'
			. '<option value="">Нет данных</option>'
			. '</select>';
	}

	$html = '<select name="' . htmlspecialchars($name) . '"' . ($required ? ' required' : '') . '>';

	foreach ($options as $option) {
		if (!is_array($option))
			continue;

		$value = htmlspecialchars($option[$valueField] ?? '');
		$display = htmlspecialchars($option[$displayField] ?? '');
		$selected = ($selectedValue !== null && ($option[$valueField] ?? null) == $selectedValue)
			? ' selected' : '';

		$html .= '<option value="' . $value . '"' . $selected . '>' . $display . '</option>';
	}

	$html .= '</select>';
	return $html;
}

/**
 * Валидирует данные формы перед созданием сущности
 * 
 * @param array $data Данные формы
 * @param array $requiredFields Обязательные поля
 * @return array Массив с ошибками или пустой массив, если ошибок нет
 */
function validateFormData(array $data, array $requiredFields): array
{
	$errors = [];

	foreach ($requiredFields as $field) {
		if (empty($data[$field])) {
			$errors[$field] = 'Это поле обязательно для заполнения';
		}
	}

	return $errors;
}