<?php

include('connectMySQL.php'); 
  
  session_start();

$query1 = "select count(*) from user, users_online where users_online.userid=user.userid";
$result = mysql_query($query1);

if($result == false) {
	die(mysql_error());
}

$row = mysql_fetch_array($result);
echo "<font size=4 color='white'><b><center>Chat (" .  $row[0] . ")</center></b></font>";

$db->disconnect(); 


?>