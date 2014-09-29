<?php

function isort1($a,$b) {
    
	if($a->date <  $b->date) {
		return -1;
	}
	
	if($a->date >  $b->date) {
		return 1;
	}
	
	return 0;
}


function constructGenderGroup($meetupid, $activitytypeid, $course, $gender, $last_time_male, $last_time_female, &$count) {

	$count = 0;
	
	if($activitytypeid == 29 || $activitytypeid == 32) {
		$query = "select userid from user where user.gender=$gender and not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid  and user_reject_activity.userid=user.userid) order by rand()";
	} else if($activitytypeid == 27 || $activitytypeid == 28) {
		$query = "select user.userid from courses, user where courses.userid=user.userid and user.gender=$gender and course=$course and not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid and user_reject_activity.userid=courses.userid)";
	} else {
		$query = "select userid2, comfortability from friends, user where user.userid=friends.userid2 and user.gender=$gender and userid1=" . $_SESSION['home_user'] . " and not exists (select userid from user_reject_activity where activitytypeid=$activitytypeid and user_reject_activity.userid=friends.userid2)";
	}
	
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	if(mysql_num_rows($result) == 0) { 
		if($gender == 1) {
			return $last_time_male;
		}

		return $last_time_female;
	}

	$today = strtotime(date("Y-m-d"));
	
	
	if($result){
		
		while($row = mysql_fetch_array($result)) {
			$userid = $row[0];
			
			if($gender == 1) {
				$last_time_male[$userid]->date = 0;
				$last_time_male[$userid]->userid = $userid;
			} else {
				$last_time_female[$userid]->date = 0;
				$last_time_female[$userid]->userid = $userid;
			}
			
			
			$query = "select UNIX_TIMESTAMP(max(timestamp)) from last_n_activities where userid=$userid and activitytypeid=$activitytypeid";
			$tmp = mysql_query($query);
			
			if($tmp == false) {
				die(mysql_error());
			}
			
			$row1 = mysql_fetch_array($tmp);
			
			if(mysql_num_rows($tmp) > 0) { 
				
				$prev_date = date("Y-m-d", $row1[0]);
				$datetime1 = new DateTime($prev_date);
				$datetime2 = new DateTime();
				$interval = $datetime1->diff($datetime2);
				$interval = intval($interval->format('%R%a'));
				
				if($gender == 1) {
					$last_time_male[$userid]->date = $row1[0];
				} else {
					$last_time_female[$userid]->date = $row1[0];
				}

				if($interval > 10) {
					$count++;
				} else {
					if($gender == 1) {
						$last_time_male[$userid]->userid = -1;
					} else {
						$last_time_female[$userid]->userid = -1;
					}
				}
				
			} else {
				$count++;
			}
		}
		
	} else {
		die(mysql_error());
	}
	
	if($gender == 1) {
		return $last_time_male;
	}

	return $last_time_female;
}

function createInvites($meetupid, $last_time, $upper_buond) {

	$count = 0;
	usort($last_time, "isort1");
	
	foreach ($last_time as $i) {
	
		if($i->userid < 0) {
			continue;
		}
	
		$query = "insert into invites values ($i->userid, $meetupid, 0, 0, now())";
		$tmp = mysql_query($query);
		
		if($tmp == false) {
			die(mysql_error());
		}
		
		$query = "update alerts set invites=invites+1 where userid=$i->userid";
		$tmp = mysql_query($query);
		
		if($tmp == false) {
			die(mysql_error());
		}
		
		$count = $count + 1;
		if($count > $upper_buond) {
			break;
		}
	}
}

function findActivityGroup($meetupid, $activitytypeid, $course) {

	$last_time_male = array();
	$last_time_female = array();
	$count = 0;
	
	if($activitytypeid == 30) {
		// girls night out
		$last_time_female = constructGenderGroup($meetupid, $activitytypeid, $course, 0, $last_time_male, $last_time_female, $count);
	} else if($activitytypeid == 31) {
		// boys night out
		$last_time_male = constructGenderGroup($meetupid, $activitytypeid, $course, 1, $last_time_male, $last_time_female, $count);
	} else {
		$last_time_male = constructGenderGroup($meetupid, $activitytypeid, $course, 1, $last_time_male, $last_time_female, $count);
		$last_time_female = constructGenderGroup($meetupid, $activitytypeid, $course, 0, $last_time_male, $last_time_female, $count);
	}
	
	if($count < 2) { 
		return false;
	}
	
	if($meetupid < 0) {
		return true;
	}
	
	$query = "select peoplerange from categories where activitytypeid=$activitytypeid";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	$lower_bound = strtok($row[0], '-');
	$upper_bond = strtok('-');
	
	if($activitytypeid == 30) {
		// girls night out
		createInvites($meetupid, $last_time_female, $upper_bond);
	} else if($activitytypeid == 31) {
		// boys night out
		createInvites($meetupid, $last_time_male, $upper_bond);
	} else {
		createInvites($meetupid, $last_time_female, $upper_bond >> 1);
		createInvites($meetupid, $last_time_male, $upper_bond >> 1);
	}
			
	$query = "insert into invites values (" . $_SESSION['home_user'] . ", $meetupid, 0, 0, 1)";
	$tmp = mysql_query($query);
	
	$query = "update alerts set invites=invites+1 where userid=" . $_SESSION['home_user'];
	$tmp = mysql_query($query);
	
	return true;
}
	

?>