
<?php

session_start();



include('connectMySQL.php'); 

$meetupid = $_REQUEST['user'];

$query = "select activityid, activitytypeid from meetups where meetupid=$meetupid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
if($result == false) {
	die(mysql_error());
}

$activitytypeid = $row['activitytypeid'];

$query = "update friends, meetups set last_invite=meetups.date_recorded where friends.userid1=" . $_SESSION['home_user'] . " and meetups.meetupid=$meetupid and friends.userid2 in (select userid from invites where meetupid=$meetupid)";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "update activity set popularity=popularity+1 where activityid=" . $row['activityid'];
$result = mysql_query($query);
if($result == false) {
	die(mysql_error());
}

$query = "update categories set popularity=popularity+1 where activitytypeid=" . $row['activitytypeid'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

if(isset($_REQUEST['status']) == true) {
	$query = "update invites set invites.person_count=" . $_REQUEST['status'] . ", accept=2 where userid=" . $_SESSION['home_user'] . " and meetupid=$meetupid";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}

} else {

	$query = "update invites set accept=1, timestamp=now() where meetupid=$meetupid and userid=" . $_SESSION['home_user'];
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}
	
	$query = "update alerts set meetings=meetings+1 where userid=" . $_SESSION['home_user'];
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}
}

include('check_invite_status.php');
checkInviteStatus($meetupid);

if($activitytypeid != 36) {

	// not a date set up
	$query = "select accept from invites where meetupid=$meetupid and userid=" . $_SESSION['home_user'];
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}

	$row = mysql_fetch_array($result);
	$is_maybe = $row[0];
	
	$query = "insert into invite_updates values (" . $_SESSION['home_user'] . ", $meetupid, " . $is_maybe . " , now(), -1)";
	$tmp = mysql_query($query);
	
	$query = "select userid from invites where meetupid=$meetupid";
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	} 

	while($row = mysql_fetch_array($result)){

		if($row['userid'] != $_SESSION['home_user']) {
			
			$query = "update alerts set invites=invites+1 where userid=" . $row['userid'];
			$tmp = mysql_query($query);
			
			if($tmp == false) {
				die(mysql_error());
			}
		}
	}
}

$db->disconnect(); // disconnect after use is a good habit

header("Location: invites.php");
	

?>