<?php

session_start();
include('connectMySQL.php'); 

$userid1 = $_SESSION['home_user'];
$userid2 = $_REQUEST['user'];

$query = "delete from indv_meetup where userid1=$userid1 and userid2=$userid2";
$tmp = mysql_query($query);

$db->disconnect(); // disconnect after use is a good habit

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>