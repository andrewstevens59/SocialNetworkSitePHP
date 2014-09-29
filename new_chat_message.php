<?php

include('connectMySQL.php'); 
  
  session_start();
  
$timestamp = $_REQUEST['prev_time'];
$query = "select messages.userid from messages, message_sent_to where messages.messageid=message_sent_to.messageid and message_sent_to.userid=" . $_SESSION['home_user'] . " and messages.timestamp > 'timestamp'";
$result = mysql_query($query);

echo "'" . date("Y-m-d h:i:s") . "'*";


if($result == false) {
	die(mysql_error());
}

while($row = mysql_fetch_array($result)){

	echo $row['userid'] . "*";
}

$db->disconnect(); 

?> 