<?php

include('select_activity.php');

$activitytypeid = selectActivity();

$query = "select activity.activityid from categories, activity_category, activity where categories.type=activity_category.type and activity_category.activityid=activity.activityid and categories.activitytypeid=$activitytypeid order by activity.popularity desc";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$row = mysql_fetch_array($result);
$activityid = $row[0];

if($activitytypeid == 27 || $activitytypeid == 28) {
	// course related
	$query = "select course from courses where userid=" . $_SESSION['home_user'] . " order by rand() limit 1";
	$result = mysql_query($query);
	if(mysql_num_rows($result) == 0) {
		return;
	}
	
	$row = mysql_fetch_array($result);
	$course = $row[0];
} else if($activitytypeid == 36) {
	// date set up
	$query = "select userid2 from friends, user where userid1=" . $_SESSION['home_user'] . " and user.gender=1 and user.userid=friends.userid2 order by rand()";
	$result = mysql_query($query);
	
	if($result == false) {	
		die(mysql_error());
	}

	if(mysql_num_rows($result) == 0) {
		return;
	}
	
	$row = mysql_fetch_array($result);
	$date_user1 = $row[0];
	
	$query = "select userid2 from friends where userid1=" . $_SESSION['home_user'] . " and gender=0 order by rand()";
	$result = mysql_query($query);

	if(mysql_num_rows($result) == 0) {
		return;
	}
	
	$row = mysql_fetch_array($result);
	$date_user1 = $row[0];
}

include('formulate_activity.php');

$total_num = 0;
foreach($friend_set as $i) {
	if($i->accept_num == 0) {
		$total_num++;
	}
}

if($total_num < $lower_bound) {
	return;
}

$query = "insert into meetups values('', $activityid, '$time', '$date', $activitytypeid)";
$result = mysql_query($query);

if($result == false) {	
	die(mysql_error());
}

$query = "select max(meetupid) from meetups";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$meetupid = $row[0];

if($result == false) {
	die(mysql_error());
}

$is_added = false;
$people_num = $upper_bond;
foreach($friend_set as $i) {

	if($people_num  == 0) { 
		break;
	}

	if($i->accept_num == 0) {
		$people_num--;
		
		if($i->userid == $_SESSION['home_user']) {
			$is_added = true;
		}
		
		$query = "insert into invites values ($i->userid, $meetupid, 0, 0, now())";
		$result = mysql_query($query);

		if($result == false) {
			die(mysql_error());
		}
		
		$query = "update alerts set invites=invites+1 where userid=$i->userid";
		$result = mysql_query($query);

		if($result == false) {
			die(mysql_error());
		}
		
		$query = "insert into last_n_activities values (" . $_SESSION['home_user'] . "," . $activitytypeid . ", now())";
		$result = mysql_query($query);
	}
}

if($is_added == false) {
	// don't forget to invite yourself
	$query = "insert into invites values (" . $_SESSION['home_user'] . ", $meetupid, 0, 0, now())";
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}

	$query = "update alerts set invites=invites+1 where userid=" . $_SESSION['home_user'];
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}
	
	$query = "insert into last_n_activities values (" . $_SESSION['home_user'] . "," . $activitytypeid . ", now())";
	$result = mysql_query($query);
}

$query = "update user set last_meetup=now() where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

?>