<?php

  
  session_start();

include('connectMySQL.php'); 

$query = "delete from blind_date where  userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from last_n_activities where activitytypeid=33 and userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$db->disconnect(); // disconnect after use is a good habit


header('Location: ' . $_SERVER['HTTP_REFERER']);

?> 