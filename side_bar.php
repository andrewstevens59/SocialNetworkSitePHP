<div id="alert" style="border: 20px outset blue ; background-color: rgb(255, 255, 255); z-index:100; top:30%; width:40%; left:30%; height:25%; display:none;  position: absolute;" onmouseover='is_set=true;' onmouseout='is_set=false;'></div>
	
	<script type="text/javascript">
	
	function showAlerts(alert_type) {
	
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
				document.getElementById("alert").innerHTML = text;
				document.getElementById("alert").style.display="block";
			}
		}

		var text = "alert_results.php?type=";
		text += alert_type;
		
		
		xmlhttp.open("GET", text, true);
		xmlhttp.send();
	}
	
	</script>
	
	<style type="text/css">

.rounded-corners {
     -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    -khtml-border-radius: 10px;
    border-radius: 10px;
	border: 2px solid blue;
	padding: 0.7em;
}


</style>


<?php

$query1 = "select friends, messages, meetings from alerts where userid = " . $_SESSION['home_user'];

$result = mysql_query($query1);

if($result){

	$row = mysql_fetch_array($result);
	$message_num = $row['messages'];
	$friend_num = $row['friends'];

	echo "<div class='rounded-corners'><img src='" . $_SESSION['thumb'] . "' width=300px height=300px></div><p>";
	
	echo "<div class='rounded-corners'>";
	
echo "<table>";

	if($message_num == 0) {
		echo "<tr><td><img src='message.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'people_messages.php'\"><font size=5>Messages</font><p>";
	} else {
		echo "<tr><td><img src='message.jpg' width=25px height=25px>&nbsp;&nbsp;<td style='background-color:blue;' onmouseover=\"this.style.backgroundColor='#0000CC';\" onmouseout=\"this.style.backgroundColor='blue';\" onclick=\"window.location = 'people_messages.php'\"><font size=5 color=red>Messages (" . $message_num . ")</font><p>";
	}
	
	if($friend_num == 0) {
		echo "<tr><td><img src='smiley.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'friends_page.php'\"><font size=5>Friends</font><p>";
	} else {
		echo "<tr><td><img src='smiley.jpg' width=25px height=25px>&nbsp;&nbsp;<td style='background-color:blue;' onmouseover=\"this.style.backgroundColor='#0000CC';\" onmouseout=\"this.style.backgroundColor='blue';\" onclick=\"window.location = 'friends_page.php'\"><font size=5 color=red>Friends (" . $friend_num . ")</font><p>";
	}
	

echo "<tr><td><img src='info.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'user_page.php'\"><font size=5>Information</font><p>";
echo "<tr><td><img src='lock.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'privacy.php'\"><font size=5>Privacy</font><p>";
echo "<tr><td><img src='gallery.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'gallery.php'\"><font size=5>Photos</font><p>";
echo "<tr><td><img src='wall.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'wall.php'\"><font size=5>Wall</font><p>";
echo "<tr><td><img src='news_feed.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'news.php'\"><font size=5>News</font><p>";
echo "<tr><td><img src='invite.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'invites.php'\"><font size=5>Invites</font><p>";
echo "<tr><td><img src='calender.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'meetups.php'\"><font size=5>Meetups</font><p>";

echo "</table></div>";

echo "<td width=3%><td width=75% height=1000 valign=top>";
} else {

	die(mysql_error()); 
}


?>