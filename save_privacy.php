<?php

  
  session_start();

$photos = mysql_real_escape_string($_REQUEST['photos']);
$information = mysql_real_escape_string($_REQUEST['information']);
$wall = mysql_real_escape_string($_REQUEST['wall']);
$friends = mysql_real_escape_string($_REQUEST['friends']);
$meetups = mysql_real_escape_string($_REQUEST['meetups']);

include('connectMySQL.php'); 

$query = "UPDATE Privacy SET meetups=" .$meetups .", photos=" .$photos .", information=" .$information . ",wall=" . $wall . ",friends=" . $friends . " WHERE userid=\"" .$_SESSION['home_user'] ."\"";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$db->disconnect(); // disconnect after use is a good habit

header("Location: privacy.php");
	

?> 