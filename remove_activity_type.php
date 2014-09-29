
<?php

session_start();

include('connectMySQL.php'); 

$meetupid = $_REQUEST['id'];
$activitytypeid = $_REQUEST['activity'];
$query = "delete from invites where meetupid=$meetupid and userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "insert into user_reject_activity values(" . $_SESSION['home_user'] . ",$activitytypeid)";
$result = mysql_query($query);

$query = "select userid from invites where meetupid=$meetupid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

while($row = mysql_fetch_array($result)){

	if($row['userid'] != $_SESSION['home_user']) {
		$query = "insert into invite_updates values (" . $_SESSION['home_user'] . "," . $row['userid'] . ", $meetupid, 0, now(), 1)";
		$tmp = mysql_query($query);
		
		if($tmp == false) {
			die(mysql_error());
		}
		
		$query = "update alerts set invites=invites+1 where userid=" . $row['userid'];
		$result = mysql_query($query);
		
		if($tmp == false) {
			die(mysql_error());
		}
	}
}

$db->disconnect(); // disconnect after use is a good habit

header("Location: invites.php");
	

?>