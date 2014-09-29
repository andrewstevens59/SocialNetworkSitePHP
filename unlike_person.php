
<?php

session_start();



include('connectMySQL.php'); 

$userid = $_REQUEST['user'];

$query = "insert into like_person values(" . $_SESSION['home_user'] . ",$userid)";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "update alerts set alerts.alerts=alerts.alerts+1 where userid=$userid";
$temp = mysql_query($query);

$query = "insert into alert_updates values (" . $_SESSION['home_user'] . ", $userid, -2, 'likes <B>you</B> ', NOW(), 1)";
$result = mysql_query($query);


$db->disconnect(); 

header("Location: invites.php");
	

?>