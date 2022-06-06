<?php
require_once '../src/db.class.php';
	$host = 'localhost';
	$db = DB::$dbName;
	$username = DB::$user;
	$pwd = DB::$password;
	$dns = "mysql:host=$host;dbname=$db";
	
	try {
		$conn = new PDO($dns, $username, $pwd);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e) {
		echo "connection failed: ".$e->getMessage();
	}
?>
