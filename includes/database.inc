<?php

global $database;



	if ( preg_match("/hdtest/", $_SERVER['SERVER_NAME'])) { 
		#$database = mysql_connect ("76.12.97.29", "hdtestcom", 	"HarmonyDesigns1"); //or die ('I cannot connect to the database because: ' . mysql_error());
		$database = mysql_connect ("localhost", "hdtest", 	"HarmonyDesigns1"); //or die ('I cannot connect to the database because: ' . mysql_error());
		#mysql_select_db( "hdtestcom", $database );
		mysql_select_db( "hdtest", $database );
	} else if ( preg_match("/malysoft/", $_SERVER['SERVER_NAME'])) {
		$database = mysql_connect ("localhost", "harmony_main", "harmony_main1");
		##error_log("IN HERE");
		if (!$database) { error_log ('I cannot connect to the database because: ' . mysql_error()); }
		if (!mysql_select_db( "harmony_main", $database ))
		{
			#error_log("CANNOT SELECT DB: " .mysql_error());
		}
	} else if ( $_SERVER['SERVER_NAME'] == 'harmonydesigns.cypressinternet.com') {
		$database = mysql_connect ("localhost", "tomasm", "tomas_maly1"); //or die ('I cannot connect to the database because: ' . mysql_error());
		mysql_select_db( "tomasm", $database );
	} else {
		$database = mysql_connect ("127.0.0.1", "harmonyd_admin", "no-gkyL4^P6h"); //or die ('I cannot connect to the database because: ' . mysql_error());
		mysql_select_db( "harmonyd_main", $database );	
	}

#echo "DB=$database (SN=".$_SERVER['SERVER_NAME'].")";

if(!function_exists("get_db_records"))
{

function pluralize($word)
{
	return preg_match("/s$/", $word) ? $word : $word."s";
}

function do_sql($sql)
{
	global $database;

	#error_log("SQL=$sql");

	return mysql_query($sql, $database);
}

function insert_db_record($table, $data = array())
{
	global $database;
	if (!count($data))
	{
		#error_log("EMPTY INSERT (no data specified): $table");
		return;
	}

	$set = generate_sql_set($data);

	$query = "INSERT INTO $table SET $set";
	do_sql($query);
	$id = mysql_insert_id($database);
	return $id; # Primary key for record.
}

function update_db_record($table, $data = array(), $where_array = array())
{
	global $database;
	if (!count($where_array))
	{
		#error_log("EMPTY QUERY (not changing all records): $table");
		return;
	}

	if (!count($data))
	{
		#error_log("EMPTY UPDATE (no data specified): $table");
		return;
	}

	$where = generate_sql_where($where_array);
	$set = generate_sql_set($data);

	$query = "UPDATE $table SET $set WHERE $where";
	$result = do_sql($query, $database);
	$rows = mysql_affected_rows($database);
	#error_log("UPDATE ROWS=$rows");
	return $rows; # If didn't exist, will return -1
}

function generate_sql_set($data = array())
{
	$set = "";
	foreach ($data as $k=>$v) { $set .= ($set != "" ? ", " : "") . (($k && $k !== 1) ? " $k = '$v'" : $v); }
	return $set;
}

function generate_sql_where($params = array())
{
	$param_query = "";
	if (is_array($params))
	{
		foreach ($params as $k=>$v) { 
			$param_set = ($k && !is_numeric($k)) ? "$k = '$v'" : $v;
			$param_query .= ($param_query != "" ? " AND " : "") . $param_set;
		}
		# If key is blank or is numeric(index)...
	} else {
		$param_query = $params;
	}
	# We can mix by: 'x'=>2, 'complex_sql_expn', ...
	if (!$param_query) { $param_query = "1=1"; }
	return $param_query;
}

function db_get_field($table, $params, $field) # Just one field, ie a name.
{
	$record = get_db_record($table, $params, null, array($field));
	return !empty($record[$field]) ? $record[$field] : null;
}

function db_get_record($table, $params = array(), $order = "", $fields = '*')
{
	return get_db_record($table, $params, $order, $fields);
}

function get_db_record($table, $params = array(), $order = "", $fields = '*')
{
	global $database;

	$param_query = generate_sql_where($params);

	if (is_array($fields))
	{
		$field_csv = join(", ", $fields);
	} else {
		$field_csv = $fields;
	}

	$query = "SELECT $field_csv FROM $table WHERE $param_query";
	if ($order != "") { $query .= " ORDER BY $order"; }
	$query .= " LIMIT 1";
	$result = mysql_query($query, $database);
	if(!$result)
	{
		echo "Invalid query ($query): ".mysql_error();
	}
	$record = mysql_fetch_assoc($result);
	return $record;
}

function db_get_records($table, $params = array(), $order = "", $fields = '*')
{
	return get_db_records($table, $params, $order, $fields);
}

function get_db_records($table, $params = array(), $order = "", $fields = '*')
{
	global $database;

	$param_query = generate_sql_where($params);

	if (is_array($fields))
	{
		$field_csv = join(", ", $fields);
	} else {
		$field_csv = $fields;
	}

	$query = "SELECT $field_csv FROM $table WHERE $param_query";
	if ($order != "") { $query .= " ORDER BY $order"; }
	$result = mysql_query($query, $database);
	$records = array();
	#if($table == 'cart_items') { echo "Q=$query<br/>"; }
#error_log($query);
	while($record = mysql_fetch_assoc($result))
	{
		$records[] = $record;
	}
	#echo "q=$query";
	#print_r($records);
	return $records;
}

function map_db_records($data, $key, $value_key = '')
{
	$mapped_data = array();
	foreach($data as $item)
	{
		if(!empty($value_key))
		{
			$value = $item[$key];
			$value_value = $item[$value_key];
			$mapped_data[$value] = $value_value;
		} else {
			$value = $item[$key];
			$mapped_data[$value] = $item;
		}
	}
	return $mapped_data;
}

}


?>
<? 
	include_once(dirname(__FILE__)."/tracking.inc"); 
?>
