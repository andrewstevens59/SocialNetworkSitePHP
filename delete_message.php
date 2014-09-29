<?php

  
  session_start();

$messageid = mysql_real_escape_string($_REQUEST['id']);
include('connectMySQL.php'); 

$query = "delete from message_sent_to where messageid=$messageid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from messages where messageid=$messageid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

	

?> 