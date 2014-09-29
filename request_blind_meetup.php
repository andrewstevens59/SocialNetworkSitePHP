<?php

session_start();

include('find_activity_time.php');

function createBlindMeetup($result) {

	$row = mysql_fetch_array($result);
	$userid1 = $row['userid'];
	$userid2 = $_SESSION['home_user'];
	
	$query = "delete from blind_date where userid=$userid1";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}

	$query = "select activity.activityid from activity, activity_category where activity.activityid=activity_category.activityid and activity_category.type='indv meetup' ORDER BY RAND() LIMIT 0,1";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$row = mysql_fetch_array($result);
	$activityid = $row[0];
	
	$query = "insert into meetups values('', $activityid, '', now(), 33)";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}

	$query = "select max(meetupid) from meetups";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$row = mysql_fetch_array($result);
	$meetupid = $row[0];
	
	createActivityTime($activityid, 10, $meetupid);
	
	echo "SDfs";
	
	$query = "insert into invites values (" . $_SESSION['home_user'] . ", $meetupid, 0, 0, now())";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "insert into invites values ($userid1, $meetupid, 0, 0, now())";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "update alerts set invites=invites+1 where userid=$userid1";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "update alerts set invites=invites+1 where userid=" . $_SESSION['home_user'];
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "insert into arranged_date values($userid1, $userid2, now())";
	$result = mysql_query($query);

	$query = "insert into arranged_date values($userid2, $userid1, now())";
	$result = mysql_query($query);
	
	$query = "update user set last_meetup=now() where userid=$userid1";
	$tmp = mysql_query($query);
	
	$query = "update user set last_meetup=now() where userid=$userid2";
	$tmp = mysql_query($query);
	
	return $userid1;
}


include('connectMySQL.php'); 

$query = "select UNIX_TIMESTAMP(dob) from user where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);
$row = mysql_fetch_array($result);

$prev_date = date("Y-m-d", $row[0]);
$datetime1 = new DateTime($prev_date);
$datetime2 = new DateTime();
$interval = $datetime1->diff($datetime2);
$age = $interval->y;

$query = "select u2.userid from blind_date b2, user u1, user u2 where u2.userid=b2.userid and u1.userid=" . $_SESSION['home_user'] . " and not exists (select userid2 from arranged_date where userid1=" . $_SESSION['home_user'] . ") and u2.userid!=" . $_SESSION['home_user'];


if(isset($_REQUEST['seeking'])) {
	$_SESSION['seeking'] = $_REQUEST['seeking'];
	$_SESSION['age_end'] = $_REQUEST['age_end'];
	$_SESSION['age_start'] = $_REQUEST['age_start'];
	$_SESSION['ethnicity'] = $_REQUEST['ethnicity'];
}

if($_SESSION['seeking'] == 0) {
	$query .= " and b2.type=1";
} else if($_SESSION['seeking'] == 1) {
	$query .= " and b2.type=0";
} else if($_SESSION['seeking'] == 5) {
	$query .= " and b2.type=5";
} else if($_SESSION['seeking'] == 6) {
	$query .= " and b2.type=6";
}

$query .= " and u2.dob >= DATE_SUB(NOW(), INTERVAL " . $_SESSION['age_end'] . " YEAR)";
$query .= " and u2.dob <= DATE_SUB(NOW(), INTERVAL " . $_SESSION['age_start'] . " YEAR)";

$query .= " and b2.age_end >= $age and b2.age_start <= $age";

if($_SESSION['ethnicity'] != 13) {
	$query .= " and u2.ethnicity=" . $_SESSION['ethnicity'];
}

$query .= " and u1.ethnicity=b2.ethnicity";

$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

if(mysql_num_rows($result) == 0) {
	$query = "insert into blind_date values(" . $_SESSION['home_user'] . "," . $_SESSION['seeking'] . "," . $_SESSION['age_start'] . "," . $_SESSION['age_end'] . "," . $_SESSION['ethnicity'] . ")";
	$result = mysql_query($query);
	
} else {
	createBlindMeetup($result);
}


$db->disconnect(); // disconnect after use is a good habit

header("Location: blind_meetups.php");

?>