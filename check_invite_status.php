<?php

function checkInviteStatus($meetupid) {

	$state = array();
	$query = "select accept, userid from invites where meetupid=$meetupid";
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}
	
	while($row = mysql_fetch_array($result)){
		$state[$row['userid']] = $row['accept'];
	}

	$query = "update invites set accept=1 where accept!=0 and meetupid=$meetupid";
	$result = mysql_query($query);
		
	$prevcount = -1;
	while(true) {
	
		$query = "select count(*) from invites where meetupid=$meetupid and accept=1";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		if($row[0] == $prevcount) {
			break;
		}
		
		$prevcount = $row[0];
		
		$query = "update invites set accept=2 where accept=1 and person_count>$prevcount and meetupid=$meetupid";
		$result = mysql_query($query);
	}
	
	$query = "select accept, userid from invites where meetupid=$meetupid";
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}
	
	while($row = mysql_fetch_array($result)){
		if($state[$row['userid']] != $row['accept']) {
		
			$query = "delete from invite_updates where meetupid=$meetupid and accept=" . $state[$row['userid']] . " and userid=" . $row['userid'];
			$tmp = mysql_query($query);

			$query = "update alerts set meetings=meetings+1 where userid=" . $row['userid'];
			$tmp = mysql_query($query);
			
			$query = "update alerts set invites=invites+1 where userid=" . $row['userid'];
			$tmp = mysql_query($query);
			
			$query = "update invites set timestamp=now() where userid=" . $row['userid'] . " and meetupid=$meetupid";
			$tmp = mysql_query($query);
			
			$query = "insert into invite_updates values (" . $row['userid'] . ", $meetupid, " . $row['accept'] . ", now(), -1)";
			$tmp = mysql_query($query);
		}
	}
}

?>