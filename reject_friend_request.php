<?php

  
  session_start();
  
$userid1 = mysql_real_escape_string($_REQUEST['user']);
include('connectMySQL.php'); 

$query = "delete from friend_request where userid1=$userid1 and userid2=" .$_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

	

?> 