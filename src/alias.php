<?php
session_start();
require_once 'db.class.php';
$alias=$_POST['alias'];

$row = DB::queryFirstRow("SELECT username FROM users WHERE username=%s LIMIT 1", $alias);

if($row==""){
    $ok=DB::insert('users', [
        'username' => $alias
    ]);
    if($ok==1){
        $_SESSION['alias']=$_SESSION['usr_id'];
        #get alias id
        $row = DB::queryFirstRow("SELECT user_id FROM users WHERE username=%s LIMIT 1", $alias);

        $_SESSION['usr_id']=$row['user_id'];
        var_dump($_SESSION);
        echo "ok";

    }else echo "error";
}else
{
    echo "error";
    }


?>