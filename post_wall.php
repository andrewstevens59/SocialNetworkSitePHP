<?php

  
  session_start();

$userid1 = $_SESSION['home_user'];
$userid2 = mysql_real_escape_string($_REQUEST['user']);
$message = mysql_real_escape_string($_REQUEST['message']);
$message = mysql_escape_string($_REQUEST['message']);

include('connectMySQL.php'); 

include('add_to_album.php'); 
$photo_dir = addToAlbum();

if(isset($_REQUEST['hide']) == true) {
	$query = "insert into wall values ($userid1, '$message', NOW(), $userid2, '', '$photo_dir', 1)";
} else {
	$query = "insert into wall values ($userid1, '$message', NOW(), $userid2, '', '$photo_dir, 0)";
}

$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}


if($userid1 != $userid2) {

	$query = "update friends set interactions=interactions+1 where userid2=$userid2 and userid1=$userid1";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}

	$query = "select max(wallid) from wall";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$wallid = $row[0];
	
	$query = "insert into alert_updates values ($userid1, $userid2, $wallid, 'posted on your wall<br><b>$message</b>', NOW())";
	$result = mysql_query($query);
	
	$query = "update alerts set alerts=alerts+1 where userid=$userid2";
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error()); 
	}
}

$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

	

?> 