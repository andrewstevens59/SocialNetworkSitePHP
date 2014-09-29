<?php

session_start();


include('connectMySQL.php'); 

$activityid = $_REQUEST['id'];
$activitytypeid = $_REQUEST['type'];
$date = $_REQUEST['date'];
$time = $_REQUEST['time'];

$query = "insert into meetups values('', $activityid, '$time', '$date', $activitytypeid)";
$result = mysql_query($query);

if($result == false) {	
	die(mysql_error());
}

$query = "insert into last_n_activities values (" . $_SESSION['home_user'] . "," . $activitytypeid . ", now())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "select max(meetupid) from meetups";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$meetupid = $row[0];

$query = "update user set last_meetup=$date where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$total_invites = $_REQUEST['total_invites'];

for($i=0; $i<$total_invites; $i++) {

	if(isset($_REQUEST[$i]) == true) {
		$query = "insert into invites values (" . $_REQUEST[$i] . ", $meetupid, 0, 0, now())";
		$tmp = mysql_query($query);
		
		if($tmp == false) {
			die(mysql_error());
		}
		
		$query = "update alerts set invites=invites+1 where userid=" . $_REQUEST[$i];
		$tmp = mysql_query($query);
		
		if($tmp == false) {
			die(mysql_error());
		}
	}
}

if($activitytypeid != 36) {
	$query = "insert into invites values (" . $_SESSION['home_user'] . ", $meetupid, 0, 0, now())";
	$tmp = mysql_query($query);

	if($tmp == false) {
		die(mysql_error());
	}

	$query = "update alerts set invites=invites+1 where userid=" . $_SESSION['home_user'];
	$tmp = mysql_query($query);

	if($tmp == false) {
		die(mysql_error());
	}
}

$db->disconnect(); 

header('Location: activities.php');

?>