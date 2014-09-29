<?php

  
  session_start();

$userid1 = $_REQUEST['user1'];
$userid2 = $_REQUEST['user2'];
$commentid = mysql_real_escape_string($_REQUEST['id']);
$wallid = mysql_real_escape_string($_REQUEST['wallid']);

include('connectMySQL.php'); 

$query = "insert into wall_comment_like values ($commentid, " . $_SESSION['home_user'] . ", now())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}


if($userid1 != $_SESSION['home_user'] && $userid1 >= 0) {
	$query = "update alerts set alerts.alerts=alerts.alerts+1 where userid=$userid1";
	$temp = mysql_query($query);

	$query = "insert into alert_updates values (" . $_SESSION['home_user'] . ", $userid1, $wallid, 'likes your comment', NOW())";
	$result = mysql_query($query);
}

if($userid1 != $userid2 && $userid2 != $_SESSION['home_user'] && $userid2 >= 0) {
	$query = "update alerts set alerts.alerts=alerts.alerts+1 where userid=$userid2";
	$temp = mysql_query($query);

	$query = "insert into alert_updates values (" . $_SESSION['home_user'] . ", $userid2, $wallid, 'likes your comment', NOW())";
	$result = mysql_query($query);
}


$db->disconnect(); 

	

?> 