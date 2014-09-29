<?php

session_start();

include('find_activity_time.php');
include('connectMySQL.php'); 

$query = "select count(*) from indv_meetup where userid1=" . $_SESSION['home_user'];
$result = mysql_query($query);
$row = mysql_fetch_array($result);
if($row[0] >= 30) {
	$db->disconnect(); 
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	return;
}

$userid1 = $_SESSION['home_user'];
$userid2 = $_REQUEST['user'];

$query = "insert into indv_meetup values ($userid1, $userid2, now())";
$tmp = mysql_query($query);

$query = "select * from indv_meetup a, indv_meetup b where a.userid1=$userid1 and a.userid2=$userid2 and b.userid2=$userid1 and b.userid1=$userid2";
$tmp = mysql_query($query);

if(mysql_num_rows($tmp) > 0) {

	$query = "delete from indv_meetup where userid1=$userid1 and userid2=$userid2";
	$tmp = mysql_query($query);
	
	$query = "delete from indv_meetup where userid1=$userid2 and userid2=$userid1";
	$tmp = mysql_query($query);
	
	$query = "select * from arranged_date where userid1=$userid1 and userid2=$userid2";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}

	if(mysql_num_rows($result) > 0) {
		// dating second meetup
		$query = "select activity.activityid, popularity from activity, activity_category where activity_category.type='dating' and activity.activityid=activity_category.activityid ORDER BY popularity desc limit 0,1";
		$activitytypeid = 34;
	} else {
		// at St Lucia campus first meetup
		$query = "select activity.activityid from activity, activity_category where activity_category.type='indv meetup' and activity.activityid=activity_category.activityid ORDER BY RAND() LIMIT 0,1";
		$activitytypeid = 33;
	}

	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$row = mysql_fetch_array($result);
	$activityid = $row[0];

	$query = "insert into meetups values('', $activityid, '', now(), $activitytypeid)";
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
	
	$date = createActivityTime($activityid, 10, $meetupid);

	$query = "select max(meetupid) from meetups";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$meetupid = $row[0];
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "insert into arranged_date values ($userid2, $userid1, FROM_UNIXTIME($date))";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "insert into arranged_date values ($userid1, $userid2, FROM_UNIXTIME($date))";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "insert into invites values ($userid2, $meetupid, 0, 0, now())";
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
	
	$query = "update alerts set invites=invites+1 where userid=$userid2";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}

	$query = "update user set last_meetup=FROM_UNIXTIME($date)";
	$tmp = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
}


$db->disconnect(); // disconnect after use is a good habit

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>