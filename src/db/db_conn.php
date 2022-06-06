<?php
require_once '../src/db.class.php';
$host = 'localhost';
$db = DB::$dbName;
$username = DB::$user;
$pwd = DB::$password;


    $conn = mysqli_connect($host, $username, $pwd, $db);
    
    if( !$conn ) 
        die("CONNECTION FAILED: ".mysqli_connect_error());
?>
