
<?php

session_start();
include('connectMySQL.php'); 

$meetupid = $_REQUEST['id'];
$activityid = $_REQUEST['activity'];
$time = $_REQUEST['time'];

$query = "select activityid, time from meetups where meetupid=$meetupid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

if($result == false) {
	die(mysql_error());
}

if($row['activityid'] == $activityid && $row['time'] == $time) {
	$db->disconnect(); 
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	return;
}

$query = "update meetups set time='$time' where meetupid=$meetupid";
$result = mysql_query($query);

if($row[0] != $activityid) {
	$query = "update activity set popularity=popularity+1 where activityid=" . $activityid;
	$result = mysql_query($query);
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "update activity set popularity=popularity-1 where activityid=" . $row[0];
	$result = mysql_query($query);
	if($result == false) {
		die(mysql_error());
	}
}


if($result == false) {
	die(mysql_error());
}

$query = "update meetups set activityid=$activityid where meetupid=$meetupid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "delete from invite_updates where meetupid=$meetupid and accept=4";
$tmp = mysql_query($query);

if($tmp == false) {
	die(mysql_error());
}

$query = "insert into invite_updates values (" . $_SESSION['home_user'] . ", $meetupid, 4 , now(), -1)";
$tmp = mysql_query($query);

if($tmp == false) {
	die(mysql_error());
}

$query = "select userid from invites where meetupid=$meetupid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

while($row = mysql_fetch_array($result)){

	if($row['userid'] != $_SESSION['home_user']) {
		
		$query = "update alerts set invites=invites+1 where userid=" . $row['userid'];
		$tmp = mysql_query($query);
		
		if($tmp == false) {
			die(mysql_error());
		}
	}
}

$db->disconnect(); // disconnect after use is a good habit

header('Location: ' . $_SERVER['HTTP_REFERER']);
	

?>