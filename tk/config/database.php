<?php
function getDBConnection()
{
	$con = pg_connect('host=localhost port=5432 dbname=tk user=postgres password=123');
	if (!$con) {
		throw new Exception("Ошибка подключения к базе данных: " . pg_last_error());
	}
	return $con;
}
?>