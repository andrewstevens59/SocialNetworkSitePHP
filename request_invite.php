
<?php

session_start();


include('connectMySQL.php'); 

$userid = $_REQUEST['user'];
$meetupid = $_REQUEST['id'];

$query = "insert into invite_updates values (" . $_SESSION['home_user'] . ", $meetupid, 5, now(), -1)";
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

header('Location: ' . $_SERVER['HTTP_REFERER']);
	

?>