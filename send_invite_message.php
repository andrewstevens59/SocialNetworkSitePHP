<?php


session_start();

include('connectMySQL.php'); 

$meetupid = mysql_real_escape_string($_REQUEST['user']);
$message = mysql_real_escape_string($_REQUEST['message']);

$query = "insert into invite_message values ($meetupid, " . $_SESSION['home_user'] . ", '$message', now(), '')";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "select max(messageid) from invite_message where meetupid=$meetupid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$message_row = mysql_fetch_array($result);

$query = "insert into invite_updates values (" . $_SESSION['home_user'] . ", $meetupid, 3 , now(), " . $message_row[0] . ")";
$tmp = mysql_query($query);

if($tmp == false) {
	die(mysql_error());
}

$query = "select userid from invites where meetupid=$meetupid";
$result = mysql_query($query);

while($row = mysql_fetch_array($result)){

	if($row['userid'] != $_SESSION['home_user']) {
		
		$query = "update alerts set invites=invites+1 where userid=" . $row['userid'];
		$tmp = mysql_query($query);
		
		if($tmp == false) {
			die(mysql_error());
		}
	}
}


$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

?>