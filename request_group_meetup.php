<?php

session_start();

include('find_activity_time.php');
include('connectMySQL.php'); 

$meetupids = array();
$male_user_meetups = array();
$female_user_meetups = array();

$user_set = array();

$final_user_set = array();

$query = "select invites.userid, meetupid from female_date, invites where female_date.userid=invites.userid and blind=0";
$result = mysql_query($query);

while($row = mysql_fetch_array($result)) {
	array_push($female_user_meetups, $row['userid']);
	$meetupids[$row['meetupid']] = false;
	$user_set[$row['userid']] = array();
}

$query = "select invites.userid, meetupid from male_date, invites where male_date.userid=invites.userid and blind=0";
$result = mysql_query($query);

while($row = mysql_fetch_array($result)) {
	array_push($male_user_meetups, $row['userid']);
	$meetupids[$row['meetupid']] = false;
	$user_set[$row['userid']] = array();
}

$query = "select invites.userid, meetupid from female_date, invites where female_date.userid=invites.userid and blind=0";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

while($row = mysql_fetch_array($result)) {
	array_push($user_set[$row['userid']], $row['meetupid']);
}

$query = "select invites.userid, meetupid from male_date, invites where male_date.userid=invites.userid and blind=0";
$result = mysql_query($query);

while($row = mysql_fetch_array($result)) {
	array_push($user_set[$row['userid']], $row['meetupid']);
}

function isValidUser($userid) {

	foreach ($user_set[$userid] as $i) {
		if($meetupids[$i] == true) {
			return false;
		}
	}

	foreach ($user_set[$userid] as $i) {
		$meetupids[$i] = true;
	}
	 
	return true;
}

if($result == false) {
	die(mysql_error());
}

$query = "select meetupid from invites where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

while($row = mysql_fetch_array($result)) {
	$meetupids[$row['meetupid']] = true;
}

array_push($final_user_set, $_SESSION['home_user']);
$set = 0;


if($_SESSION['gender'] != "male") {
	$set = 1;	
}

$size1 = 0;
$size2 = 0;

while(sizeof($final_user_set) < 8) {

	if(($set % 2) == 0) {
		while(true) {
		
			if($size1 >= sizeof($female_user_set)) {
				$query = "insert into female_date values (" . $_SESSION['home_user'] . ", 0, now())";
				$tmp = mysql_query($query);
				
				$db->disconnect(); 
				header("Location: group_meetups.php");
				return;
			}
		
			if(isValidUser($female_user_set[$size1]) == true) {
				array_push($final_user_set, $female_user_set[$size1]);
				break;
			}
			
			$size1 = $size1 + 1;
		}
	} else {
		
		while(true) {
		
			if($size2 >= sizeof($male_user_set)) {
				$query = "insert into male_date values (" . $_SESSION['home_user'] . ", 0, now())";
				$tmp = mysql_query($query);
				
				$db->disconnect(); 
				header("Location: group_meetups.php");
				return;
			}
			
			if(isValidUser($male_user_set[$size2]) == true) {
				array_push($final_user_set, $male_user_set[$size2]);
				break;
			}
			
			$size2 = $size2 + 1;
		}
	}
	
	$set = $set + 1;	
}

$query = "select activityid from activity where type='grpup date' ORDER BY RAND() LIMIT 0,1";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

$activityid = $row[0];

if($result == false) {
	die(mysql_error());
}

$query = "insert into meetups values('', $activityid, '', '', now())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "select max(meetupid) from meetups";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$meetupid = $row[0];

createActivityTime($activityid, 10, $meetupid);

if($result == false) {
	die(mysql_error());
}

foreach ($final_user_set as $i) {
	$query = "insert into invites values ($i, $meetupid, 0, 0, 1)";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "update alerts set invites=invites+1 where userid=$i";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "delete from male_date where userid=$i and blind=0";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "delete from female_date where userid=$i and blind=0";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "update user set last_meetup=now() where userid=$i";
	$tmp = mysql_query($query);
}

$db->disconnect(); 

header("Location: group_meetups.php");

?>