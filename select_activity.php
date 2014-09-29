<?php
function isort2($a,$b) {
    
	if($a->time < $b->time) {
		return -1;
	}
	
	if($a->time >  $b->time) {
		return 1;
	}
	
	return 0;
}

class Activity {
	var $time;
	var $id;
}

function make_seed1()
{
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

function selectActivity($activitytypeid = -1) {

	$last_activity = array();
	
	srand(make_seed1());
	
	if($activitytypeid < 0) {
		// find an activity type
		$query = "select activitytypeid, popularity from categories";
	} else { 
		// find an activity id
		$query = "select activity.activityid, activity.popularity from categories, activity_category, activity where categories.activitytypeid=$activitytypeid and categories.type=activity_category.type and activity.activityid=activity_category.activityid";
	}
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}


	$min_pop = 0;
	while($row = mysql_fetch_array($result)) {
		// not a blind meetup
		$last_activity[$row[0]] = new Activity();
		$last_activity[$row[0]]->time = 0;
		$last_activity[$row[0]]->popularity = $row[1];
		$last_activity[$row[0]]->id = $row[0];
		$min_pop = min($min_pop, $row[1]);
	}

	$sum = 0;
	if($activitytypeid < 0) {
		$query = "select UNIX_TIMESTAMP(timestamp), activitytypeid from last_n_activities where userid=" . $_SESSION['home_user'];
		$result = mysql_query($query);

		if($result == false) {
			die(mysql_error());
		}

		while($row = mysql_fetch_array($result)) {
			$last_activity[$row['activitytypeid']]->time = max($last_activity[$row['activitytypeid']]->time, $row[0]);
		}

		usort($last_activity, "isort2");
		
		foreach($last_activity as $i) {
			// shifts to allow for negative popularity so all popularity >= 0
			$i->popularity += abs($min_pop) + 1;
			$sum = $sum + $i->popularity;
		}
	} else {

		foreach($last_activity as $i) {
			$i->popularity += abs($min_pop) + 1;
			$sum = $sum + $i->popularity;
		
		}
	}
	
	foreach($last_activity as $i) {
		$i->popularity /= $sum;
		$i->popularity *= 1000;
	
	}

	$offset = 0;
	$rev_map = array();
	foreach($last_activity as $i) {
		for($j=0; $j<$i->popularity; $j++) {
			$rev_map[$offset++] = $i->id;
		}
	}

	if($activitytypeid < 0) {
		// only the half of the activity types that have been done least recently
		$offset >>= 1;
	} 
	
	$id = rand() % $offset;
	return $rev_map[$id];
}
?>