<?php
session_start();
$_SESSION['usr_id']=$_SESSION['alias'];
unset($_SESSION['alias']);
?>
