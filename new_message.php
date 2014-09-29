<div id='new_page'>

<script type="text/javascript">

  function scrollToBottom()
  {
    window.scrollTo(0,document.body.scrollHeight);
  }
  
  window.onload=scrollToBottom;
  
  </script>

<?php


session_start();



include('connectMySQL.php'); 

$user_id1 = $_SESSION['home_user'];
$user_id2 = $_REQUEST['user'];

$query = "select firstname, surname, thumb from user where user.userid = $user_id2";
$result = mysql_query($query);
$send_person = "";
$thumb = "";

if($result){

	$row = mysql_fetch_array($result);
	$send_person = $row['firstname'] . " " . $row['surname'];
	$thumb = $row['thumb'];
} else {
	die(mysql_error()); // useful for debug
}

include('banner.php');
drawBanner(false, $user_id1);

$query = "select thumb, firstname, surname, message, user.userid, messages.messageid from messages, user, message_sent_to where ((messages.userid = " .$user_id1 ." and message_sent_to.userid = " .$user_id2 .") or (messages.userid = " .$user_id2 ." and message_sent_to.userid = " .$user_id1 ."))  and user.userid = messages.userid and message_sent_to.messageid=messages.messageid";
$result = mysql_query($query);
$tmp_string = "";

if(mysql_num_rows($result) > 0) {
	$tmp_string .= "<div class='layout'>";
	$tmp_string .= "<div style='background-color:#F2F2F2'>";
}

if($result){
	
	while($row = mysql_fetch_array($result)){
	
		$tmp_string .= "<div>";
	    $tmp_string .= "<table><tr>";
		$tmp_string .= "<td><a href='user_page.php?user=" . $row['userid'] . "'><img src='" . $row ['thumb'] . "' height=70px width=70px></a>";
		$tmp_string .= "<td><b><a href='user_page.php?user=" . $row['userid'] . "'>" .$row ['firstname'] . " " . $row ['surname'] ."</a></b>&nbsp;&nbsp;<a href='delete_message.php?id=" . $row['messageid'] . "'><img src='cross.jpg' width=7px height=7px></a><br>";
		
		$tmp_string .= $row ['message'];
		$tmp_string .= "</table></div><hr color='#E6E6FA'>";
	}
	
	if(mysql_num_rows($result) > 0) {
		$tmp_string .= "</div></div>";
	}
	
	$tmp_string .= "<p><div class='layout'><form ACTION=\"post_message.php?user=$user_id2\" METHOD=POST><table><tr>";
	$tmp_string .= "<td><img src='" . $_SESSION['micro_image'] . "' height=70px width=70px>";
	$tmp_string .= "<td><textarea id=\"message\" rows=1 cols=90 onkeyup=\"resizeTextarea(this)\" onmouseup=\"resizeTextarea(this)\"></textarea>";
	$tmp_string .= "<td><a href='' onclick='reloadPage(\"post_message.php\", \"user=$user_id2&message=\" + document.getElementById(\"message\").value, \"new_message.php?user=$user_id2\", \"new_page\");return false;'><img src='send1.jpg'  onmouseover='this.src=\"send2.jpg\"' onmouseout='this.src=\"send1.jpg\"'></a></table></form></div>";
	$tmp_string .= "</table>";


} else {
	die(mysql_error()); // useful for debug
}


echo "<div class='layout'><table><tr>";
echo "<td><img src='$thumb' width=70px height=70px>";
echo "<td width=5%><td><font size=6><b>" . $send_person;
echo " <img src='arrow.jpg' width=20px height=20px> Messages </b></font></div><p>";
echo "</table></div><p>";

echo $tmp_string;

$db->disconnect(); // disconnect after use is a good habit

?>

</div>