<?php


session_start();



include('connectMySQL.php'); 

$userid1 = $_SESSION['home_user'];
$message = mysql_real_escape_string($_REQUEST['message']);

$userid2 = 0;
if(isset($_REQUEST['user'])) {
	$userid2 = $_REQUEST['user'];
}

$is_same_user = 1;
if($userid1 == $userid2) {
	$is_same_user = 0;
}

$query = "update friends set interactions=interactions+1 where userid2=$userid2 and userid1=$userid1";
$result = mysql_query($query);

$query = "insert into messages values ('" . $message ."'," . $userid1 .",now(), '')";
$result = mysql_query($query);

$query = "select max(messages.messageid) from messages where userid=$userid1";
$result = mysql_query($query);

$row = mysql_fetch_array($result);

$query = "insert into message_sent_to values (" . $userid2 . "," . $row[0] . ")";
$result = mysql_query($query);

if($result){


} else {
	die(mysql_error()); // useful for debug
}

$query = "SELECT * FROM alerts WHERE userid = $userid2";
$result = mysql_query($query);
if(mysql_num_rows($result) == 1) {
    $query = "update alerts set messages = messages + $is_same_user where userid = $userid2";
	$result = mysql_query($query);
}
else {
   $query = "insert into alerts values ($userid2, $is_same_user, 0)";
   $result = mysql_query($query);
}

if($result){


} else {
	die(mysql_error()); // useful for debug
}


$db->disconnect(); 


header("Location: new_message.php?user=" . $userid2);

?>