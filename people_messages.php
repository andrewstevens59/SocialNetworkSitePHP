<?php


session_start();

include('connectMySQL.php'); 



$query = "update alerts set messages=0 where userid=" .$_SESSION['home_user'];
$temp = mysql_query($query);

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$query = "select thumb, firstname, surname, message, messages.userid, messages.messageid, user.userid from messages, message_sent_to, user where message_sent_to.userid = " .$_SESSION['home_user'] ." and user.userid = messages.userid and messages.messageid=message_sent_to.messageid and messages.timestamp > '" . $_SESSION['last_login'] . "' order by firstname, surname";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

if(mysql_num_rows($result) > 0) {
	echo "<table width=92%><tr><td><div class='rounded-corners' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> New Messages</b></font></div><p>";
	echo "<div class='rounded-corners' style='border:2px solid red'>";
	
	while($row = mysql_fetch_array($result)){

		echo "<div $hover onclick=\"window.location = 'new_message.php?user=" . $row ['userid'] . "'\"><table><tr>";
		echo "<td><a href='user_page.php?user=" . $row['userid'] . "'><img src='" . $row ['thumb'] . "' height=70px width=70px></a>";
		echo "<td><b><a href='user_page.php?user=" . $row['userid'] . "'>" .$row ['firstname'] . " " . $row ['surname'] ."</a></b><br>" . $row['message'];
		echo "</table></div><p>";
	}

	echo "</div></table><p>";
}


echo "<div class='layout'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Messages</b></font></div><p><div class='layout'>";

	echo "<center><table><tr>";
	echo "<form ACTION=\"search.php?type=1&user=" . $_SESSION['home_user'] . "\" METHOD=POST autocomplete=\"off\">";
	
	?>
	<td valign=middle><input type="text" style="height: 35px;font-size:20px;" name="search" size="80" onkeyup="showSearchRes('friends_page', this.value, 2, 10);"></td>
	<td valign=middle><input type="image" VALUE="Search" src='search1.jpg' onmouseover='this.src="search2.jpg"' onmouseout='this.src="search1.jpg"'></td>

	</form></table></center></div><p><div class='layout' id='friends_page'>
	


<?php

$query = "select thumb, firstname, surname, thumb, userid from user where userid in (select messages.userid from messages, message_sent_to where messages.messageid=message_sent_to.messageid and message_sent_to.userid=" .$_SESSION['home_user'] ." union select message_sent_to.userid from messages, message_sent_to where messages.userid=" .$_SESSION['home_user'] ." and message_sent_to.messageid=messages.messageid) order by firstname, surname";
$result = mysql_query($query);

if($result){


	while($row = mysql_fetch_array($result)){
	    echo "<div $hover onclick=\"window.location = 'new_message.php?user=" . $row ['userid'] . "'\"><table><tr>";
		echo "<td><a href='user_page.php?user=" . $row['userid'] . "'><img src='" . $row ['thumb'] . "' height=70px width=70px></a>";
		echo "<td><b><a href='user_page.php?user=" . $row['userid'] . "'>" .$row ['firstname'] . " " . $row ['surname'] ."</a></b><br>";
		echo "</table></div><p>";
	}
	
	echo "</div></table>";

} else {
	die(mysql_error()); // useful for debug
}


$db->disconnect(); // disconnect after use is a good habit


?>