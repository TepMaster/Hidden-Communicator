<?php
session_start();
require_once 'db.class.php';
include_once 'include/check_user.php';
require  '../vendor/autoload.php';
use phpseclib3\Crypt\DH;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\Random;

	//reciving the the msg from newmsg() function in chatbox.php
	$msg = $_POST['msg'];
	$rid = $_POST['rid'];
	//inserting the msg into database here flagmsg is 1 by default


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
if($_SESSION['usr_id']>$rid){
	$chat_id=sha1($_SESSION['usr_id']).sha1($rid);
}else{
	$chat_id=sha1($rid).sha1($_SESSION['usr_id']);
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
$encrypted = $encrypter->encryptString($msg);

DB::insert('messages', [
	'sender_id' => $_SESSION["usr_id"],
	'msg' => $encrypted,
	'receiver_id' => $rid
]);

?>
