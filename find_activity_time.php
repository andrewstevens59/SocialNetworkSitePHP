

<?php

function make_seed()
{
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

function createActivityTime($activityid, $interval, $meetupid) {

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
	
	$time;
	$date1;
	
	$tok1 = strtok($buff[0], " ");
	$tok2 = strtok(" ");
	
	$starttime = strtok($tok2, "-");
	$width = strtok("-");

	$day = date("N");
	
	$starttime = $starttime + (rand() % $width);
	
	if($tok1 == "weekdays") {
	
		$next_day = ($day + 3) % 7;
	
		if($next_day == 6) {
			// Saturday
			$date1 = 6;
		} else if($next_day == 0) {
			// Sunday
			$date1 = 5;
		} else {
			$date1 = 3;
		}
		
	} else {
	
		$next_day = ($day + 3) % 7;
		
		
		if($starttime < 17) {
			// too early in the day
			if($day < 5) {
				if(rand() % 2) {
					$date1 = 6 - $day;
				} else {
					$date1 = 7 - $day;
				}
			} else {
				if(rand() % 3) {
					$date1 = 13 - $day;
				} else {
					$date1 = 14 - $day;
				}
			}
		} else {
		
			// later in the day include Friday night
			
			$sel = rand() % 3;
			
			if($day < 4) {
				if($sel == 0) {
					$date1 = 5 - $day;
				} else if($sel == 1) { 
					$date1 = 6 - $day;
				} else {
					$date1 = 7 - $day;
				}
				
			} else {
				if($sel == 0) {
					$date1 = 12 - $day;
				} else if($sel == 1) { 
					$date1 = 13 - $day;
				} else {
					$date1 = 14 - $day;
				}
			}
		}
	}
	
	$mysqldate = date('Y-m-d H:i:s');
	$phpdate = strtotime("$mysqldate +$date1 days");

	$query = "update meetups set date_recorded=FROM_UNIXTIME($phpdate) where meetupid=$meetupid";
	$result = mysql_query($query);

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
	

	$query = "update meetups set time='$time' where meetupid=$meetupid";
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}
	
	return $phpdate;
}

?>
