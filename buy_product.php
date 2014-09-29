<?php

include('connectMySQL.php'); 
  
  session_start();

$query = "insert into buy_product values (" . $_SESSION['home_user'] . "," .  $_REQUEST['id'] . ")";
$result = mysql_query($query);

$query = "update alerts set product=product+1 where userid=" . $_REQUEST['user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}


$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

	

?> 