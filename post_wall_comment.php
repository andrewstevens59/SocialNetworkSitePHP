<?php

  
  session_start();

$wallid = $_REQUEST['wallid'];
$comment = $_REQUEST['comment'];
$userid1 = $_REQUEST['user1'];
$userid2 = $_REQUEST['user2'];

include('connectMySQL.php'); 
$photo_dir = "";

$query = "insert into wall_comment values ($wallid, '$comment', " . $_SESSION['home_user'] . ", '', NOW())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

if($userid1 != $_SESSION['home_user'] && $userid1 >= 0) {

	$query = "update friends set interactions=interactions+1 where userid2=$userid1 and userid1=" . $_SESSION['home_user'];
	$result = mysql_query($query);
	
	$query = "update alerts set alerts.alerts=alerts.alerts+1 where userid=$userid1";
	$temp = mysql_query($query);

	$query = "insert into alert_updates values (" . $_SESSION['home_user'] . ", $userid1, $wallid, 'commented on your status<br>$comment', NOW())";

	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error()); 
	}
}

if($userid1 != $userid2 && $userid2 != $_SESSION['home_user'] && $userid2 >= 0) {

	$query = "update friends set interactions=interactions+1 where userid2=$userid2 and userid1=" . $_SESSION['home_user'];
	$result = mysql_query($query);

	$query = "update alerts set alerts.alerts=alerts.alerts+1 where userid=$userid2";
	$temp = mysql_query($query);

	$query = "insert into alert_updates values (" . $_SESSION['home_user'] . ", $userid2, $wallid, 'commented on your status<br>$comment', NOW())";
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error()); 
	}
}

$db->disconnect(); 

	

?> 