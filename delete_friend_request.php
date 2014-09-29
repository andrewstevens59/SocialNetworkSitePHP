<?php

  
  session_start();

$userid2 = mysql_real_escape_string($_REQUEST['user']);

include('connectMySQL.php'); 
$query = "delete from friend_request where userid2='$userid2' and userid1='" . $_SESSION['home_user'] . "'";

$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$db->disconnect(); // disconnect after use is a good habit


header('Location: ' . $_SERVER['HTTP_REFERER']);

?> 