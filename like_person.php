
<?php

session_start();



include('connectMySQL.php'); 

$query = "select count(*) from like_person where userid2=" . $_SESSION['home_user'];
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$like_count = $row[0];

if($like_count >= 60) {
	$db->disconnect(); 
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	return;
}

$userid = $_REQUEST['user'];

$query = "insert into like_person values(" . $_SESSION['home_user'] . ",$userid, now())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "update alerts set alerts.alerts=alerts.alerts+1 where userid=$userid";
$temp = mysql_query($query);

$query = "insert into alert_updates values (" . $_SESSION['home_user'] . ", $userid, -2, 'likes <B>you</B> ', NOW(), 1)";
$result = mysql_query($query);


$db->disconnect(); 

header('Location: ' . $_SERVER['HTTP_REFERER']);
	

?>