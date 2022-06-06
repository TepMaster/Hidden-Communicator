<?php
session_start();
require_once 'db.class.php';
$url ='';
switch ($_POST['prof']){
    case 0:
        $url='pic1.jpg';
        break;
    case 1:
        $url='pic2.jpg';
        break;
    case 2:
        break;
    case 3:
        break;
}
$_SESSION['prof']=$url;
DB::update('users', ['prof_img' => $url], "user_id=%s", $_SESSION['usr_id']);
?>
