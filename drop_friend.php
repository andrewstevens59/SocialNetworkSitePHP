<?php


session_start();


include('connectMySQL.php'); 



$userid = $_SESSION['home_user'];
if(isset($_REQUEST['user'])) {
	$userid = $_REQUEST['user'];
}

$query = "delete from friends where userid1 = " . $_SESSION['home_user'] . " and userid2=$userid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "delete from friends where userid2 = " . $_SESSION['home_user'] . " and userid1=$userid";
$result = mysql_query($query);

$db->disconnect();

header('Location: friends_page.php');

?>
