<?php

include('connectMySQL.php'); 
  
  session_start();
  
  
  
$user_id1 = $_REQUEST['chat_user'];
$user_id2 = $_SESSION['home_user'];

$query1 = "select firstname, surname, user.userid from user where userid=$user_id1";
$result = mysql_query($query1);

if($result == false) {
	die(mysql_error());
}
$row = mysql_fetch_array($result);
echo "<div style='background-color:#E6E6FA;width:100%;height:20px;' ><center><b>Send A Message To " . $row['firstname'] . " " . $row['surname'] . "</b></center></div>";
	
$query = "select thumb, firstname, surname, message, user.userid, messages.messageid from messages, user, message_sent_to where ((messages.userid = " .$user_id1 ." and message_sent_to.userid = " .$user_id2 .") or (messages.userid = " .$user_id2 ." and message_sent_to.userid = " .$user_id1 .")) and messages.timestamp > '" . $_SESSION['last_login'] . "' and user.userid = messages.userid and message_sent_to.messageid=messages.messageid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

if($result){
	
	while($row = mysql_fetch_array($result)){
	
		echo "<div>";
		echo "<table><tr>";
		echo "<td><a href='user_page.php?user=" . $row['userid'] . "'><img src='" . $row ['thumb'] . "' height=50px width=50px></a>";
		echo "<td><b><a href='user_page.php?user=" . $row['userid'] . "'>" .$row ['firstname'] . " " . $row ['surname'] ."</a></b>&nbsp;&nbsp;";
		
		echo $row ['message'];
		echo "</table></div>";
	}

} else {
	die(mysql_error()); // useful for debug
	}

$db->disconnect(); 

?> 