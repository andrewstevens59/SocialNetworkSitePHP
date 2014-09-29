
<?php

session_start();


include('connectMySQL.php'); 

$meetupid = $_REQUEST['user'];
$query = "delete from invites where meetupid=$meetupid and userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "select activityid, activitytypeid from meetups where meetupid=$meetupid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
if($result == false) {
	die(mysql_error());
}

$query = "update activity set popularity=popularity-1 where activityid=" . $row['activityid'];
$result = mysql_query($query);
if($result == false) {
	die(mysql_error());
}

$query = "update categories set popularity=popularity-1 where activitytypeid=" . $row['activitytypeid'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "insert into invite_updates values (" . $_SESSION['home_user'] . ", $meetupid, 0, now(), -1)";
$tmp = mysql_query($query);

if($tmp == false) {
	die(mysql_error());
}

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

$db->disconnect(); // disconnect after use is a good habit

header("Location: invites.php");
	

?>