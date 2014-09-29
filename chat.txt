<?php

include('connectMySQL.php'); 
  
  session_start();
  
$query = "select name from product where productid=" . $_REQUEST['id'];
$result = mysql_query($query);
$row = mysql_fetch_array($result);

if($result == false) {
	die(mysql_error()); 
}

$query = "insert into alert_updates values (" . $_SESSION['home_user'] . "," .  $_REQUEST['user'] . ", -1, '<b><a href=\'show_product.php?id=" . $_REQUEST['id'] . "\'> " . $row['name'] . "</a></b> can now be purchased. See here for the exchange details.', now())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "insert into alert_updates values (" . $_SESSION['home_user'] . "," .  $_SESSION['home_user'] . ", -1, 'You have accepted the purchase request for <b><a href=\'show_product.php?id=" . $_REQUEST['id'] . "\'> " . $row['name'] . "</a></b>. See here for the exchange details.', now())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "update alerts set alerts=alerts+1 where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "update alerts set alerts=alerts+1 where userid=" . $_REQUEST['user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from buy_product where productid=" . $_REQUEST['id'] . " and userid=" . $_REQUEST['user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}


$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

	

?> 