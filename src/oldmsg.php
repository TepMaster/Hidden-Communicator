<?php 
	session_start();
	require_once 'db.class.php';
	include_once 'include/check_user.php';
	include_once "db/db_conn_pdo.php";
	require  '../vendor/autoload.php';
	$r_id = $_POST["rid"];


		$sql = "select username, is_active, prof_img from users where user_id= ?";
		$result = $conn->prepare($sql);
		$result->execute([$r_id]);
		$row = $result->fetch(PDO::FETCH_OBJ);

		$sql_user = "select user_id, is_active, prof_img from users where user_id= ?";
		$result_user = $conn->prepare($sql_user);
		$result_user->execute([$_SESSION["usr_id"]]);
		$row_user = $result_user->fetch(PDO::FETCH_OBJ);

		$msgsql = "select * from messages where (CASE when sender_id= ? and sender_flag=0 then receiver_id= ? when sender_id= ? and receiver_flag=0 then receiver_id= ? END) order by time ASC";
		$msgresult = $conn->prepare($msgsql);
		$msgresult->execute([$_SESSION["usr_id"], $r_id, $r_id, $_SESSION["usr_id"]]);

		$data = array();
		array_push($data, $row);
		array_push($data, $row_user);
		$i = 0;
		if ($msgresult->rowCount()) {
			while ($row = $msgresult->fetch(PDO::FETCH_OBJ)) {
				array_push($data, $row);
				$i++;
			}
		}
		$d = json_encode($data);
		$d = json_decode($d, true);
#KEYS
function random_str(
	int $length = 64,
	string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
	if ($length < 1) {
		throw new \RangeException("Length must be a positive integer");
	}
	$pieces = [];
	$max = mb_strlen($keyspace, '8bit') - 1;
	for ($i = 0; $i < $length; ++$i) {
		$pieces []= $keyspace[random_int(0, $max)];
	}
	return implode('', $pieces);
}

		if($_SESSION['usr_id']>$r_id){
			$chat_id=sha1($_SESSION['usr_id']).sha1($r_id);
		}else{
			$chat_id=sha1($r_id).sha1($_SESSION['usr_id']);
		}
		#verify

		$row = DB::queryFirstRow("SELECT init, rec FROM encrypted_keys WHERE init=%s LIMIT 1",$chat_id);
		if($row==""){
			$key = substr(hash("sha256",random_str()),0,32);
			DB::insert('encrypted_keys', [
				'init' => $chat_id,
				'rec' => $key
			]);
		}else
			$key =$row['rec'];


		$encrypter = new \Adbar\Encrypter($key);
		for ($da = 1; $da <= $i; $da++) {
			$string = $encrypter->decryptString($d[1 + $da]['msg']);
			$d[1 + $da]['msg'] = $string;


		}


		echo json_encode($d);

?>	
