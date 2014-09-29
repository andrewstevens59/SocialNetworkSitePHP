
<?php

session_start();


include('connectMySQL.php'); 

$meetupid = $_REQUEST['id'];
$userid = $_REQUEST['user'];

$query = "delete from invite_updates where meetupid=$meetupid and userid=$userid and accept=5";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "insert into invites values ($userid, $meetupid, 0, 0, now())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

if($result != false) {
	$query = "update alerts set invites=invites+1 where userid=$userid";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
}


$db->disconnect(); // disconnect after use is a good habit

//header('Location: ' . $_SERVER['HTTP_REFERER']);
	

?>