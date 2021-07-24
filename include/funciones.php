<?php

function query($connect, $sql, $parameters = []) {
	$query = $connect->prepare($sql);
	$query->execute($parameters);
	return $query;
}


function total($connect, $table) {
	$query = query($connect, 'SELECT COUNT(*) FROM `' . $table . '`');
	$row = $query->fetch();
	return $row[0];
}




function findById($connect, $table, $primaryKey, $value) {
	$query = 'SELECT * FROM `' . $table . '` WHERE `' . $primaryKey . '` = :value';

	$parameters = [
		'value' => $value
	];

	$query = query($connect, $query, $parameters);

	return $query->fetch();
}


function insert($connect, $table, $fields) {
	$query = 'INSERT INTO `' . $table . '` (';

	foreach ($fields as $key => $value) {
		$query .= '`' . $key . '`,';
	}

	$query = rtrim($query, ',');

	$query .= ') VALUES (';


	foreach ($fields as $key => $value) {
		$query .= ':' . $key . ',';
	}

	$query = rtrim($query, ',');

	$query .= ')';

	$fields = processDates($fields);

	query($connect, $query, $fields);
}


function update($connect, $table, $primaryKey, $fields) {

	$query = ' UPDATE `' . $table .'` SET ';


	foreach ($fields as $key => $value) {
		$query .= '`' . $key . '` = :' . $key . ',';
	}

	$query = rtrim($query, ',');

	$query .= ' WHERE `' . $primaryKey . '` = :primaryKey';

	//Set the :primaryKey variable
	$fields['primaryKey'] = $fields['id'];

	$fields = processDates($fields);

	query($connect, $query, $fields);
}



function delete($connect, $table, $primaryKey, $id ) {
	$parameters = [':id' => $id];

	query($connect, 'DELETE FROM `' . $table . '` WHERE `' . $primaryKey . '` = :id', $parameters);
}


function findAll($connect, $table) {
	$result = query($connect, 'SELECT * FROM `' . $table . '`');

	return $result->fetchAll();
}

function processDates($fields) {
	foreach ($fields as $key => $value) {
		if ($value instanceof DateTime) {
			$fields[$key] = $value->format('Y-m-d');
		}
	}

	return $fields;
}