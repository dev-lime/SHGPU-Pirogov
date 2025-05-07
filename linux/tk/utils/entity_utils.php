<?php
function getEntityName($entityId, $entities, $idField, $nameField)
{
	foreach ($entities as $entity) {
		if ($entity[$idField] == $entityId) {
			return htmlspecialchars($entity[$nameField]);
		}
	}
	return "Неизвестная запись";
}

function renderEntityLink($entityId, $entities, $idField, $nameField, $entityType)
{
	if ($entityId) {
		$name = getEntityName($entityId, $entities, $idField, $nameField);
		return '<a href="#' . $entityType . '-' . $entityId . '" class="entity-link">' . $name . '</a>';
	}
	return 'Не указан';
}
?>