<?php
abstract class BaseModel
{
	protected static $tableName;
	protected static $primaryKey;

	public static function getAll($filters = [])
	{
		$con = getDBConnection();
		$sql = "SELECT * FROM " . static::$tableName;
		$params = [];
		$where = [];
		$i = 1;

		foreach ($filters as $field => $filter) {
			if ($filter['value'] === '' || $filter['value'] === [])
				continue;

			switch ($filter['type']) {
				case 'text':
				case 'like':
					$where[] = "LOWER($field) LIKE LOWER($" . $i++ . ")";
					$params[] = '%' . $filter['value'] . '%';
					break;

				case 'exact':
					$where[] = "$field = $" . $i++;
					$params[] = $filter['value'];
					break;

				case 'date_range':
					if (!empty($filter['value']['from'])) {
						$where[] = "$field >= $" . $i++;
						$params[] = $filter['value']['from'];
					}
					if (!empty($filter['value']['to'])) {
						$where[] = "$field <= $" . $i++;
						$params[] = $filter['value']['to'];
					}
					break;

				case 'in':
					$placeholders = implode(',', array_fill(0, count($filter['value']), '$' . $i++));
					$where[] = "$field IN ($placeholders)";
					$params = array_merge($params, $filter['value']);
					break;
			}
		}

		if (!empty($where)) {
			$sql .= " WHERE " . implode(' AND ', $where);
		}

		$result = pg_query_params($con, $sql, $params);
		$items = [];
		while ($row = pg_fetch_assoc($result)) {
			$items[] = $row;
		}
		pg_close($con);
		return $items;
	}

	public static function create($connection, $data)
	{
		$columns = implode(', ', array_keys($data));
		$placeholders = '$' . implode(', $', range(1, count($data)));

		$sql = "INSERT INTO " . static::$tableName . " ($columns) VALUES ($placeholders)";
		return pg_query_params($connection, $sql, array_values($data));
	}

	public static function delete($connection, $ids)
	{
		if (empty($ids)) {
			return false;
		}

		$placeholders = implode(',', array_fill(0, count($ids), '$' . implode(', $', range(1, count($ids)))));
		$sql = "DELETE FROM " . static::$tableName . " WHERE " . static::$primaryKey . " IN ($placeholders)";
		return pg_query_params($connection, $sql, $ids);
	}
}