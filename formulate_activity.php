<?php

function sort_friends($a,$b) {
    
	if($a->comfortability < $b->comfortability) {
		return 1;
	}
	
	if($a->comfortability > $b->comfortability) {
		return -1;
	}
	
	if($a->accept_num < $b->accept_num) {
		return -1;
	}
	
	if($a->accept_num > $b->accept_num) {
		return 1;
	}
	
	if($a->last_invite < $b->last_invite) {
		return -1;
	}
	
	if($a->last_invite > $b->last_invite) {
		return 1;
	}
	
	if($a->interactions < $b->interactions) {
		return 1;
	}
	
	if($a->interactions > $b->interactions) {
		return -1;
	}
	
	return 0;
}

function isort1($a,$b) {
    
	if($a->date <  $b->date) {
		return -1;
	}
	
	if($a->date >  $b->date) {
		return 1;
	}
	
	return 0;
}

function make_seed()
{
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

	
function createActivityTime($activityid, $interval) {

	srand(make_seed());
	$query = "select times from activity where activityid=" . $activityid;
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$row = mysql_fetch_array($result);
	$tok = strtok($row[0], ",");

	$offset = 0;
	$buff = array();

	while ($tok != false) {
		
		$buff[$offset] = $tok;
		$offset = $offset + 1;
		
		$tok = strtok(",");
	}

	$tok1 = strtok($buff[0], " ");
	$tok2 = strtok(" ");
	
	$starttime = strtok($tok2, "-");
	$width = strtok("-");

	$day = date("N") - 1;
	$first_date = date("Y-m-d-h");
	
	$starttime = $starttime + (rand() % $width);
	
	if($tok1 == "weekdays" || $tok1 == "all") {

		$next_day = ($day + 3) % 7;
	
		if($next_day == 6) {
			// Saturday
			$date1 = 5;
		} else if($next_day == 0) {
			// Sunday
			$date1 = 4;
		} else {
			$date1 = 3;
		}
		
	} else {

		$next_day = ($day + 3) % 7;
		
		
		if($starttime < 17) {
			// too early in the day
			if($day < 4) {
				if(rand() % 2) {
					$date1 = 5 - $day;
				} else {
					$date1 = 6 - $day;
				}
			} else {
				if(rand() % 3) {
					$date1 = 12 - $day;
				} else {
					$date1 = 13 - $day;
				}
			}
		} else {
		
			// later in the day include Friday night
			
			$sel = rand() % 3;
			
			if($day < 4) {
				if($sel == 0) {
					$date1 = 4 - $day;
				} else if($sel == 1) { 
					$date1 = 5 - $day;
				} else {
					$date1 = 6 - $day;
				}
				
			} else {
				if($sel == 0) {
					$date1 = 11 - $day;
				} else if($sel == 1) { 
					$date1 = 12 - $day;
				} else {
					$date1 = 13 - $day;
				}
			}
		}
	}
	
	$mysqldate = date('Y-m-d');

	$phpdate = strtotime("$mysqldate +$date1 days");

	if($result == false) {
		die(mysql_error());
	}
	

	$time = $starttime;
	
	$time .= ":";
	$part = ($interval * rand()) % 60;

	if($part < 10) { 
		$time .= "0" . $part;
	} else {
		$time .= $part;
	}
	
	$date2 = date('Y-m-d', $phpdate);
	return array($date2, $time, $phpdate);
}


if(isset($_REQUEST['date']) == false) {
	list($date, $time, $phpdate) = createActivityTime($activityid, 60);
}

$friend_set = array();

if($activitytypeid == 36) {
	// date set up
	$query = "select UNIX_TIMESTAMP(dob), userid, firstname, surname, thumb, gender from user where userid=$date_user1 or userid=$date_user2";
} else if($activitytypeid == 34) {
	// dating
	$query = "select UNIX_TIMESTAMP(b.dob), b.userid, b.firstname, b.surname, b.thumb, b.gender from user a, user b where a.relid=b.userid and b.relid=a.userid and a.userid=" . $_SESSION['home_user'];
} else if($activitytypeid == 27 || $activitytypeid == 28) {
	// class related
	$query = "select UNIX_TIMESTAMP(user.dob), user.userid, firstname, surname, thumb, gender from courses, user where courses.userid=user.userid and course='$course' and not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid and user_reject_activity.userid=courses.userid) and user.userid!=" . $_SESSION['home_user'] . " order by rand() limit 1000";
} else if($activitytypeid == 30 || $activitytypeid == 31) {
	// same gender
	$query = "select userid, userid2, firstname, surname, thumb, gender, comfortability, interactions, last_invite from friends, user where user.userid=friends.userid2 and friends.userid1=" . $_SESSION['home_user'] . " and user.gender=" . $_SESSION['gender'] . " and not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid  and user_reject_activity.userid=user.userid) and user.userid!=" . $_SESSION['home_user'];
} else if($activitytypeid == 32 || $activitytypeid == 29) {
	// meet new people or group date
	$query = "select questions from user where userid=" . $_SESSION['home_user'];
	$result = mysql_query($query);
	$user_row = mysql_fetch_array($result);
		
	$query = "select UNIX_TIMESTAMP(user.dob), user.userid, questions, firstname, surname, thumb, gender from user where not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid and user_reject_activity.userid=user.userid) and user.all_qs_ans=1 and user.userid!=" . $_SESSION['home_user']. " order by rand() limit 1000";
} else {
	// any friends
	$query = "select UNIX_TIMESTAMP(dob), userid, userid2, firstname, surname, thumb, gender, comfortability, interactions, last_invite from friends, user where user.userid=friends.userid2 and friends.userid1=" . $_SESSION['home_user'] . " and not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid  and user_reject_activity.userid=user.userid) and user.userid!=" . $_SESSION['home_user'];
}

$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

while($row = mysql_fetch_array($result)){

	$friend_set[$row['userid']]->invite_num = 0;
	$friend_set[$row['userid']]->accept_num = 0;
	$friend_set[$row['userid']]->userid = $row['userid'];
	$friend_set[$row['userid']]->dob = $row[0];
	
	if($activitytypeid == 27 || $activitytypeid == 28 || $activitytypeid == 32 || $activitytypeid == 29 || $activitytypeid == 36) {
		$friend_set[$row['userid']]->comfortability = $row['gender'];
		$friend_set[$row['userid']]->interactions = 0;
		$friend_set[$row['userid']]->last_invite = 0;
		if($activitytypeid == 32 || $activitytypeid == 29) {
			$friend_set[$row['userid']]->questions = $row['questions'];
		}
	} else {
		$friend_set[$row['userid']]->comfortability = $row['comfortability'];
		$friend_set[$row['userid']]->interactions = $row['interactions'];
		$friend_set[$row['userid']]->last_invite = strtotime($row['interactions']);
	}
	
	$friend_set[$row['userid']]->gender = $row['gender'];
	$friend_set[$row['userid']]->invite = false;
	$friend_set[$row['userid']]->firstname = $row['firstname'];
	$friend_set[$row['userid']]->surname = $row['surname'];
	$friend_set[$row['userid']]->thumb = $row['thumb'];
}

if($activitytypeid == 36) {
	// date set up
	$query = "select userid, accept, date_recorded from invites, meetups where invites.meetupid=meetups.meetupid and meetups.date_recorded = '$date' and (userid=$date_user1 or userid=$date_user2)";
} else if($activitytypeid == 34) {
	$query = "select b.userid, accept, date_recorded from invites, user a, user b, meetups where invites.meetupid=meetups.meetupid and meetups.date_recorded = '$date' and invites.userid=b.relid and a.relid=b.userid and b.relid=a.userid and a.userid=" . $_SESSION['home_user'];
} else if($activitytypeid == 32 || $activitytypeid == 29) {
	$query = "select user.userid, accept, date_recorded from invites, meetups, user where invites.userid=user.userid and meetups.date_recorded = '$date' and invites.meetupid=meetups.meetupid and not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid and user_reject_activity.userid=user.userid)  and user.all_qs_ans=1 and user.userid!=" . $_SESSION['home_user'];
} else if($activitytypeid == 27 || $activitytypeid == 28) {
	$query = "select user.userid, accept, date_recorded from courses, invites, meetups, user where invites.userid=user.userid and meetups.date_recorded = '$date' and invites.meetupid=meetups.meetupid and courses.userid=user.userid and course='$course' and not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid and user_reject_activity.userid=courses.userid) and user.userid!=" . $_SESSION['home_user'];
} else if($activitytypeid == 30 || $activitytypeid == 31) {
	$query = "select user.userid, accept, comfortability, date_recorded from friends, invites, meetups, user where user.userid=invites.userid and meetups.date_recorded = '$date' and invites.meetupid=meetups.meetupid and friends.userid2=invites.userid and friends.userid1=" . $_SESSION['home_user'] . " and user.gender=" . $_SESSION['gender'] . " and not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid  and user_reject_activity.userid=invites.userid) and user.userid!=" . $_SESSION['home_user'];
} else {
	$query = "select userid, accept, comfortability, date_recorded, time from friends, invites, meetups where meetups.date_recorded = '$date' and invites.meetupid=meetups.meetupid and friends.userid2=invites.userid and friends.userid1=" . $_SESSION['home_user'] . "  and not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid and user_reject_activity.userid=friends.userid2) and invites.userid!=" . $_SESSION['home_user'];
}

$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

while($row = mysql_fetch_array($result)){

	$friend_set[$row['userid']]->invite_num++;

	
	if($row['accept'] == 1) {
		$friend_set[$row['userid']]->accept_num++;
	}
	
	$friend_set[$row['userid']]->date = $row['date_recorded'];
}

usort($friend_set, "sort_friends");

$query = "select peoplerange from categories where activitytypeid=$activitytypeid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$row = mysql_fetch_array($result);

$lower_bound = strtok($row[0], '-');
$upper_bond = strtok('-');

?>