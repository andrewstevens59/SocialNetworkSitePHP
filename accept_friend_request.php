<?php

  
  session_start();

$userid1 = mysql_real_escape_string($_REQUEST['user']);
include('connectMySQL.php'); 

$query = "update alerts set alerts.alerts=alerts.alerts+1 where userid=$userid1";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "insert into alert_updates values (" . $_SESSION['home_user'] . ", $userid1, -1, 'accepted your friend request', NOW())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}


$query = "insert into friends values(" . $_SESSION['home_user'] . ",$userid1, 0, 2, now())";
$result = mysql_query($query);

$query = "insert into friends values($userid1," . $_SESSION['home_user'] . ", 0, 2, now())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "delete from friend_request where userid1=$userid1 and userid2=" .$_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

	

?> 