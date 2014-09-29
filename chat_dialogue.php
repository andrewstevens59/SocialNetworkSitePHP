


	<center>
	<table width=100%><tr><td width=20%>
	
	<?php
	
	$query = "select thumb, firstname, surname, user.userid from user where userid in (select user.userid from messages, message_sent_to, user where message_sent_to.userid = " .$_SESSION['home_user'] ." and user.userid = messages.userid and messages.messageid=message_sent_to.messageid and messages.timestamp > '" . $_SESSION['last_login'] . "') order by firstname, surname";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$count = 0;
	echo "<table>";
	while($row = mysql_fetch_array($result)) {
	
		if($count == 0) {
			echo "<tr>";
		}
		
		echo "<td><table><tr><td><a href='' onclick='reloadPage(\"\", \"\", \"chat.php?chat_user=" . $row['userid'] . "\", \"chat\");return false;'><img src='" . $row['thumb'] . "' width=40px height=40px></a><td><a href='' onclick='contactUser(" . $row['userid'] . ");'>" . $row['firstname'] . " " . $row['surname'] . "</a></table>";
		
		$count++;
		if($count >= 3) {
			$count = 0;
		}
	}
	
	echo "</table>";
	
	?>
	
	<td width=60%>
	<center>
	<a href='' onclick='searchChat();'>Online Now</a>&nbsp;&nbsp;<a href='' onclick='searchChat();'>Chat</a>
	<table><tr>
	<td colspan="2"><div style='background-color:white;height:200px;overflow:auto;border:1px solid black' id='chat_box'></div>
	<tr><td><textarea id="message" rows=1 cols=90 onkeyup="resizeTextarea(this)" onmouseup="resizeTextarea(this)"></textarea><td>
	
	<?php
	
	if(isset($_REQUEST['chat_user']) == true) {
		echo "<a href='' onclick='reloadPage(\"post_message.php\", \"user=" . $_REQUEST['chat_user'] . "&message=\" + document.getElementById(\"message\").value, \"chat.php?chat_user=" . $_REQUEST['chat_user'] . "\", \"chat\");return false;'><img src='send1.jpg' onmouseover='this.src=\"send2.jpg\"' onmouseout='this.src=\"send1.jpg\"'></a>";

	 }
	?>
	</table></center><td width=20%>
	</table>
	
	</center>