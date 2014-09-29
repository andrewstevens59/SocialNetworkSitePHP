<script>

function reloadPage(send_page, params, load_page, div) {

		var xmlhttp;
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}
		else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

				var text = xmlhttp.responseText;
				document.getElementById(div).innerHTML = text;
				
				var elem = document.getElementById("chat_box");
				elem.scrollTop = elem.scrollHeight;
			}
		}
		
		if(send_page.length >= 2) {
			var connection;  // The variable that makes Ajax possible!
			try{// Opera 8.0+, Firefox, Safari
			connection = new XMLHttpRequest();}
			catch (e){// Internet Explorer Browsers
			try{
			connection = new ActiveXObject("Msxml2.XMLHTTP");}
			catch (e){
			try{
			connection = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (e){// Something went wrong
			return false;}}}
			
			
			connection.open("POST", send_page, false);
			connection.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			connection.setRequestHeader("Content-length", params.length);
			connection.setRequestHeader("connection", "close");
			connection.send(params);
		}

		xmlhttp.open("GET", load_page, true);
		xmlhttp.send();
	}
	
	function reloadChat() {
	
		<?php
	
		echo "reloadPage(\"\", \"\", \"chat.php?chat_user=" . $_REQUEST['chat_user'] . "\", \"chat_box\");";
		
		?>
		
		setTimeout("reloadChat()", 500);
	}
	
	function scrollToBottom()
  {

	var elem = document.getElementById("chat_box");
    elem.scrollTop = elem.scrollHeight;
	reloadChat();
  }
  
  window.onload=scrollToBottom;
	
</script>

<?php

include('connectMySQL.php'); 
include('banner.php');
  
  session_start();
  
  $userid = $_REQUEST['chat_user'];
	
	?>
	<center>
	<table width=100%><tr>
	<td colspan="2"><div style='background-color:white;height:250px;overflow:auto;border:1px solid black;bottom:0;width:100%' id='chat_box'>
	
	<?php

	$user_id1 = $userid;
	$user_id2 = $_SESSION['home_user'];
	$query = "select thumb, firstname, surname, message, user.userid, messages.messageid from messages, user, message_sent_to where ((messages.userid = " .$user_id1 ." and message_sent_to.userid = " .$user_id2 .") or (messages.userid = " .$user_id2 ." and message_sent_to.userid = " .$user_id1 .")) and messages.timestamp > '" . $_SESSION['current_login'] . "' and user.userid = messages.userid and message_sent_to.messageid=messages.messageid";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}

	while($row = mysql_fetch_array($result)){
		echo "<table><tr>";
		echo "<td><a href='user_page.php?user=" . $row['userid'] . "'><img src='" . $row ['thumb'] . "' height=50px width=50px></a>";
		echo "<td><b><a href='user_page.php?user=" . $row['userid'] . "'>" .$row ['firstname'] . " " . $row ['surname'] ."</a></b>&nbsp;&nbsp;";
		
		echo $row ['message'];
		echo "</table>";
	}

	?>
	
	</div>
	<tr><td width=100%><textarea id="message" style="width:100%" onkeyup="resizeTextarea(this)" onmouseup="resizeTextarea(this)"></textarea>
	<td>
	
	
	<?php
	
	echo "<a href='' onclick='reloadPage(\"post_message.php\", \"user=$userid&message=\" + document.getElementById(\"message\").value, \"chat.php?chat_user=$userid\", \"chat_box\");document.getElementById(\"message\").value=\"\";return false;'><img src=\"send1.jpg\"  onmouseover='this.src=\"send2.jpg\"' onmouseout='this.src=\"send1.jpg\"'></a>";
	

	?>
	
	</table></center><td width=20%>
	</table>
	
	</center>
	
	<?php

$db->disconnect(); 

?> 
