<?php
//$servername = "localhost";$dbusername = "u139323525_cypherte";$password = "Reetesh@123";$dbname = "u139323525_cypherte_aarzo";

if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    $servername = "localhost";$dbusername = "root";$password = "";$dbname = "";
    $_URL = "http://localhost";
	define('FRONT_SITE_PATH','http://localhost//');
}
else
{
	$servername = "localhost";$dbusername = "";$password = "*h";$dbname = "";
	$_URL = "https://.in/";
	define('FRONT_SITE_PATH','https://.com/');
}

error_reporting(E_ALL);

function _connectodb()
{
	global $dbname;
	global $servername;
	global $dbusername;
	global $password;
	$connect = new mysqli($servername,$dbusername,$password,$dbname);
	if($connect->connect_error)
	{
		print_r("Connection Error: " . $connect->connect_error);
		return false;
	}
	else
	{
		return $connect;
	}
}


function setTimeZone()
{
	date_default_timezone_set('Asia/Kolkata');
}

function _InsertTableRecords($conn, $sql)
{
	$response = array();
	$result = mysqli_query($conn, $sql);
	if ($result) {
		$response['message'] = "Data Inserted";
		$response['error'] = false;
		$lastId = mysqli_insert_id($conn);
		$response['last_insert_id'] = $lastId;
	} else {
		$response['sql'] = $sql;
		$response['error'] = true;
		$error = mysqli_error($conn);
		$response['message'] = $error;
		echo $sql;
		echo $error;
	}
	return $response;
}

function _UpdateTableRecords($conn, $table_name, $query_parameter)
{
	$response = array();
   	$sql = "UPDATE $table_name SET $query_parameter";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		$response['message'] = "Data Updated";
		$response['error'] = false;
	} else {
		$response['sql'] = $sql;
		$response['error'] = true;
		$error = mysqli_error($conn);
		$response['message'] = $error;
		echo $sql;
		echo $error;
	}
	return $response;
}

function delete_identity_filter($conn, $table, $query)
{
	$sql = "Delete from $table $query";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		return true;
	}
	return false;
}

function _getTableRecords($conn, $table_name, $where)
{
	$response = array();
	$sql = "Select * from $table_name $where";
	//echo $sql;
	$result = mysqli_query($conn, $sql);
	if ($result) {
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				array_push($response, $row);
			}
		}
	} else {
		//echo $sql;
	}
	return $response;
}


function _getTableDetails($conn,$table_name, $where)
{
	$row = array();
	$sql = "Select * from $table_name $where";
	$result=mysqli_query($conn,$sql);
	if($result)
		$row = $result->fetch_assoc();
	else
	{
		$error = mysqli_error($conn);
		echo $sql;
		echo $error;
	}
	return $row;
}

function _getTotalRows($conn, $table, $filter)
{
	if ($filter == "") {
		$sql = "Select COUNT(*) as no_count from $table";
	} else {
		$sql = "Select COUNT(*) as no_count from $table $filter";
	}
	//echo $sql;
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return $row['no_count'];
	} else {
		return 0;
	}
}

function check_unique_identity_filter($conn, $table, $filter)
{
	$sql = "Select * from $table $filter";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		if ($result->num_rows > 0) {
			return false;
		}
	}
	return true;
}


function UpdateUserName($conn,$newusername,$oldusername)
{
	$query_parameter = " UserName = '$newusername' where UserName = '$oldusername'";
	return _UpdateTableRecords($conn, 'users', $query_parameter);
}
date_default_timezone_set('Asia/Kolkata');


?>