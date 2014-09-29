<?php

  
  session_start();

$wallid = mysql_real_escape_string($_REQUEST['id']);
include('connectMySQL.php'); 

$query = "delete from wall where wall.wallid=$wallid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

	

?> 