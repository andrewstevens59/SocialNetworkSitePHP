<?php
  
session_start();

include('connectMySQL.php'); 

$comfortability = $_REQUEST['comfortability'];
$user = $_REQUEST['user'];

$query = "update privacy set in_rel=" . $_REQUEST['rel_priv'] . " WHERE userid=" .$_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "update friends set comfortability=$comfortability WHERE friends.userid2=$user and friends.userid1=" .$_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

if($_REQUEST['status'] == 0) {
	$query = "update user set user.relid=-1, status=" . $_REQUEST['status'] . " WHERE user.userid=" . $_SESSION['home_user'];
} else {
	$query = "update user set user.relid=$user, status=" . $_REQUEST['status'] . "  WHERE user.userid=" . $_SESSION['home_user'];
}

$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$db->disconnect(); // disconnect after use is a good habit


header('Location: friends_page.php');
	

?> 