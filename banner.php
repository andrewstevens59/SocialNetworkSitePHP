<div id="alert1" style="border: 20px outset blue ; background-color: rgb(255, 255, 255); z-index:100; top:100px; width:22%; left:30%; display:none; background-color:#E6E6FA;  position: absolute;" onmouseover='is_set=true;' onmouseout='is_set=false;'></div>

	<style>
	


a:visited {
    color: #0404B4;
    font-weight: bold;
    font-style: normal;
	text-decoration: none;
} 

.comments a:visited {
	color: #BDBDBD;
	font-weight: normal;
	font-style: normal;
} 

.comments a:hover {
	color: blue;
	font-weight: normal;
	font-style: normal;
} 

a:link {
	color: #0404B4;
	font-weight: bold;
	font-style: normal;
	text-decoration: none;
} 

select {  
	background-color:#E6E6FA;
}  

input {    
  font-size:12px; 
}  

body {
		font-family: Verdana, Geneva, sans-serif;
		font-size:12px
	}
	
img {
		border:0;
	}

textarea {  
  font-family: inherit;
  font-size: inherit;
} 

.rounded-corners {
     -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    -khtml-border-radius: 10px;
    border-radius: 10px;
	padding: 0.7em;
	background-color:#E6E6FA;
	border: 1px solid black;
}

.layout {
     -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    -khtml-border-radius: 10px;
    border-radius: 10px;
	padding: 0.7em;
	background-color:#E6E6FA;
	border: 1px solid black;
	width:90%;
}

html, body
	{
		 margin: 0;
		 padding: 0;
		 background-color:#527ED1;
	}

textarea { resize:vertical;} /* none|horizontal|vertical|both */
textarea.vert { resize:vertical; }
textarea.noResize { resize:none; }

.fixedElement {
    background-color: #709CEF;
    position:fixed;
    bottom:0;
	right:0;
    width:10%;
    z-index:100;
}


</style>


	<script type="text/javascript">
	
	var is_set = false;
	
	
	// Detect if the browser is IE or not.
	// If it is not IE, we assume that the browser is NS.
	var IE = document.all?true:false;

	// If NS -- that is, !IE -- then set up for mouse capture
	if (!IE) document.captureEvents(Event.MOUSEMOVE);

	// Set-up to use getMouseXY function onMouseMove
	document.onmousemove = getMouseXY;

	// Temporary variables to hold mouse x-y pos.s
	var tempX = 0;
	var tempY = 0;

	// Main function to retrieve mouse x-y pos.s

	function getMouseXY(e) {
	  if (IE) { // grab the x-y pos.s if browser is IE
		tempX = event.clientX + document.body.scrollLeft;
		tempY = event.clientY + document.body.scrollTop;
	  } else {  // grab the x-y pos.s if browser is NS
		tempX = e.pageX;
		tempY = e.pageY;
	  }  
	  return true
	}
	
	document.onmousedown = OnMouseDown;
	document.onscroll = scroll;
	
	function OnMouseDown(e) {

		if(is_set == false) {
			document.getElementById("alert1").style.display="none";
			document.getElementById("big_alert").style.display="none";
			document.getElementById("search_page").style.display="none";
			document.getElementById("view_image").style.display="none";
			document.getElementById("find_user").style.display="none";
		}
	}
	
	function showSearchRes(div_name, search_phrase, type, limit, meetupid) {

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
				text += "<br><center><a href='search.php?search=" + search_phrase;
				text += "&type=";
				text += type;
				text += "&user=";
				text += userid;
				
				if(type != 4 && type != 5 && type != 6) {
					text += "'>Show All Results</a></center>";
				} else {
					text += "'></a></center>";
				}
				
				document.getElementById(div_name).innerHTML = text;
				document.getElementById(div_name).style.display="block";
			}
		}
		
		if(search_phrase.length == 0 && (type==0 || type==4)) {
			document.getElementById(div_name).style.display="none";
			return;
		}

		var text = "search_results.php?search=";
		text += search_phrase;
		text += "&limit=" + limit;
		text += "&type=" + type;
		text += "&user=" + userid;
		text += "&meetupid=" + meetupid;
		
		xmlhttp.open("GET", text, true);
		xmlhttp.send();
	}
	
	userAgentLowerCase = navigator.userAgent.toLowerCase();
	 
	function resizeTextarea(t) {
	  if ( !t.initialRows ) t.initialRows = t.rows;
	 
	  a = t.value.split('\n');
	  b=0;
	  for (x=0; x < a.length; x++) {
		if (a[x].length >= t.cols) b+= Math.floor(a[x].length / t.cols);
	  }
	 
	  b += a.length;
	 
	  if (userAgentLowerCase.indexOf('opera') != -1) b += 2;
	 
	  if (b > t.rows || b < t.rows)
		t.rows = (b < t.initialRows ? t.initialRows : b);
	}
	
	function requestMeetup(count) {
	
		if(count >= 30) {
			alert("Sorry, but you are limited to 30 Meetup Requests. All requests will automatically expire in one month, otherwise you can manually cancel some of your existing requests.");
		}

		return false;
	}
	
	function requestLike(count) {
	
		if(count >= 60) {
			alert("Sorry, but you are limited to 60 Likes. All requests will automatically expire in one week");
		}

		return false;
	}
	
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
				document.getElementById("alert1").innerHTML = text;
				document.getElementById("alert1").style.display="block";
			}
		}

		var text = "alert_results.php?type=";
		text += alert_type;
		
		
		xmlhttp.open("GET", text, true);
		xmlhttp.send();
	}
	
	function getYOffset() {
		var pageY;
		if (typeof (window.pageYOffset) == 'number') {
			pageY = window.pageYOffset;
		}
		else {
			pageY = document.body.scrollTop;
		}
		return pageY;
	}
	
	function scroll() {
	
		if (getYOffset() >= window.scrollMaxY - 100 && getYOffset() < window.scrollMaxY - 50) {

			<?php 
			

			$name = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
			
			if($name == "wall.php" || $name == "news.php" || $name == "friends_page.php" || $name == "browse_pool.php" || $name == "broadcast.php" || $name == "campus_leaders.php") {
			
				$num = 10;
				if(isset($_REQUEST['num']) == true) {
					$num = $_SESSION['num'] + 10;
					$_SESSION['num'] = $num;
				} else {
					$_SESSION['num'] = 0;
				}
				
				echo "reloadPage(\"\", \"\", \"";
				echo $name . "?num=" . ($num + 10); 
				
				if(isset($_REQUEST['user']) == true) {
					echo "&user=" . $_REQUEST['user'];
				}
				
				echo "\", \"new_page\");";
			}
			
			?> 
		}
	}
	
	function showInvites(userid) {
	
		reloadPage("", "", "retrieve_invites_day.php?date=" + document.getElementById("date_set").value + "&user=" + userid, "alert1");
		document.getElementById("alert1").style.display="block";
		document.getElementById("alert1").style.top = tempY;
		document.getElementById("alert1").style.left = tempX - 200;
	}
	
	<?php
	echo "var message_date = '" . date("Y-m-d h:i:s") . "';";
	?>
	
	updateChatBox();
	
	function changeChatUser(user) {
		window.open("draw_chat_box.php?chat_user=" + user, "mywindow" + user, "status=1,width=600,height=350");
	}

	function updateChatBox() {
	
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
				var start = 0;
				var offset = 0;
				for (var i = 0; i < text.length; i++) {
					if (text.charAt(i) == '*') {
						if(offset++ == 0) {
							message_date = text.substring(start, i);
						} else {
							var user = text.substring(start, i);
							window.open("draw_chat_box.php?chat_user=" + user, "mywindow" + user, "status=1,width=600,height=350");
						}
						
						start = i + 1;	
					}
				}
			}
		}

		xmlhttp.open("GET", "new_chat_message.php?prev_time=" + message_date, true);
		xmlhttp.send();
		
		reloadPage("", "", "users_online.php", "chat");

		setTimeout("updateChatBox()", 500);
	}
	

<?php

echo "var userid=" . $_SESSION['home_user'] . ";</script>";

function calculateMatch($set1, $set2, $font_size = -1) {

	$diff = 0;
	$length = strlen($set1);
	for($i=0; $i<$length; $i++) {
		$diff += intval($set1[$i]) ^ intval($set2[$i]);
	}
	
	$perc = 1.0 - ($diff / $length);
	
	$match = intval($perc * 100);
		
	if($match > 66) {
		echo "<font color='green'>";
	} else if($match > 33) {
		echo "<font color='orange'>";
	} else {
		echo "<font color='red'>";
	}
	
	if($font_size >= 0) {
		echo "<font size='$font_size'>";
	}
	
	echo "($match% Compatability)</font>";
	
	if($font_size >= 0) {
		echo "</font>";
	}
}

$hover = "onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\"";
$other_hover = "onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='#F2F2F2';\"";

function displayViewingRights($value) {


	if($value == 0) {
		echo "<option value=0>Only Me<option value=1>Friends<option value=2>Public";
		return;
	}
	
	if($value == 1) {
		echo "<option value=1>Friends<option value=0>Only Me<option value=2>Public";
		return;
	}
	
	echo "<option value=2>Public<option value=1>Friends<option value=0>Only Me";
}
	

function drawBanner($is_other_page, $userid) {

	echo "<div style=\"background-image:url('banner.jpg'); height:70px; background-repeat: no-repeat;\" />";
	echo "<table height=75px><tr><td width=25%>";
	?>

	<form ACTION="search.php?type=0&user=" . $_SESSION['home_user'] . "\" METHOD=POST autocomplete="off">
	<td width=50%>
	<table><tr>
	<td><input type="text" style="height: 35px;font-size:20px;" name="search" size="100" onkeyup="showSearchRes('search_page', this.value, 0, 5);">
	<tr><td><div id="search_page" style="border: 1px solid black; background-color: rgb(255, 255, 255); z-index:100; display:none; width:900px; position: absolute; background-color:#E6E6FA" onmouseover='is_set=true;' onmouseout='is_set=false;'></div>
	</table>
	<td width=15%><input type="image" VALUE="Search" src='search1.jpg' onmouseover='this.src="search2.jpg"' onmouseout='this.src="search1.jpg"'></td>
	
	<td width=10% valign=middle><img src='logout1.jpg' onmouseover='this.src="logout2.jpg"' onmouseout='this.src="logout1.jpg"' onclick='window.location="logout.php"'></td>

	</form>
	


	<?php
	
	echo "</table></table></div>";
	echo "<div style=\"width:100%;background-color:	#709CEF;\">";
	echo "<table width=100%><tr>";
	
	echo "<td>";
	echo "<table><tr><td><a href=\"user_page.php?user=" . $_SESSION['home_user'] . "\">";
	echo "<img src='" . $_SESSION['micro_image'] . "' width=40px height=40px>";
	echo "<td onmouseover=\"this.style.backgroundColor='#3E6ABD';\" onmouseout=\"this.style.backgroundColor='#709CEF';\" onclick=\"window.location = 'user_page.php?user=" . $_SESSION['home_user'] . "'\"><font size=6><b>" . $_SESSION['user_name'] . "</b></font></table>";
	echo "<td>";
	

	if($userid != $_SESSION['home_user']) {
	
		echo "<center><table width=50%><tr>";
		$query = "select count(*) from like_person where userid2=" . $_SESSION['home_user'];
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$like_count = $row[0];

		$query = "select count(*) from indv_meetup where userid1=" . $_SESSION['home_user'];
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$meetup_req_count = $row[0];
	
		$query = "select * from like_person where userid1=" . $_SESSION['home_user'] . " and userid2=$userid";
		$result = mysql_query($query);
	
		if(mysql_num_rows($result) > 0) {
			echo "<td width=2%><img src='like2.jpg'>";
		} else {
			echo "<td width=2%><a href='like_person.php?user=$userid' onclick='requestLike($like_count);'><img onmouseover='this.src=\"like2.jpg\"' onmouseout='this.src=\"like1.jpg\"' src='like1.jpg'></a>";
		}
		
		$query = "select * from indv_meetup where userid1=" . $_SESSION['home_user'] . " and userid2=$userid";
		$result = mysql_query($query);
		
		if($result == false) {
			die(mysql_error()); 
		}
	
		if(mysql_num_rows($result) > 0) {
			echo "<td width=2%><a href='remove_indv_meetup.php?user=$userid'><img src='meeting3.jpg'></a>";
		} else {
			echo "<td width=2%><a href='req_indv_meetup.php?user=$userid' onclick='requestMeetup($meetup_req_count);'><img onmouseover='this.src=\"meeting2.jpg\"' onmouseout='this.src=\"meeting1.jpg\"' src='meeting1.jpg'></a>";
		}
	
		echo "<td width=2%><a href='new_message.php?user=$userid'><img onmouseover='this.src=\"message2.jpg\"' onmouseout='this.src=\"message1.jpg\"' src='message1.jpg'></a>";
		
		$query = "select * from friends where (userid2=$userid and userid1=" . $_SESSION['home_user'] . ") or (userid1=$userid and userid2=" . $_SESSION['home_user'] . ")";
		$result = mysql_query($query);
		
		if($result == false) {
			die(mysql_error()); 
		}
		
		if(mysql_num_rows($result) > 0) {
			echo "<td width=2%><img  src='friends.jpg'>";
		} else {
		
			$query = "select * from friend_request where userid2='$userid' and userid1='" . $_SESSION['home_user'] . "'";
			$result = mysql_query($query);
			
			if($result == false) {
				die(mysql_error()); 
			}
			
			if(mysql_num_rows($result) == 0) {
				echo "<td width=2%><a href='request_friend.php?user=$userid'><img onmouseover='this.src=\"add2.jpg\"' onmouseout='this.src=\"add1.jpg\"'  src='add1.jpg'></a>";
			} else {
				echo "<td width=2%><a href='delete_friend_request.php?user=$userid'><img src='friend_requested.jpg'></a>";
			}
		}
		
		echo "</center></table>";

	}
	
	echo "</div>";
	
	$query1 = "select image, firstname, surname from user where userid=$userid";
	$result = mysql_query($query1);
	$row = mysql_fetch_array($result);
	$photo = $row['image'];
	
	echo "</table></div>";
	
	echo "<div class='fixedElement' id='chat'>";
	echo "</div>";
	
	echo "<table height=100% width=90%><tr>";
	echo "<td valign=top width=20%>";
	
	$query1 = "select product, invites, alerts, friends, messages, meetings from alerts where userid = " . $_SESSION['home_user'];
	$result = mysql_query($query1);

	if($result){

		$row = mysql_fetch_array($result);
		$message_num = $row['messages'];
		$friend_num = $row['friends'];
		$alert_num = $row['alerts'];
		$invite_num = $row['invites'];
		$meeting_num = $row['meetings'];
		$product_num = $row['product'];
		
		if($userid == $_SESSION['home_user']) {
			echo "<a href='photos.php?name=profile+photos'>";
		}

		echo "<div class='layout' style='width:310px;'><center><img src='" . $photo . "' width=285px height=284px></center></div><p>";
		
		if($userid == $_SESSION['home_user']) {
			echo "</a>";
		}
	
		
		echo "<div class='layout' style='width:310px;'>";
		
		echo "<table width=100%>";

		if($userid == $_SESSION['home_user']) {
			if($message_num == 0 || $userid != $_SESSION['home_user']) {
				echo "<tr><td><img src='message.jpg' width=25px height=25px></td><td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'people_messages.php'\"><font size=5>Messages</font></td>";
			} else {
				echo "<tr><td><img src='message.jpg' width=25px height=25px>&nbsp;&nbsp;<td style='background-color:blue;' onmouseover=\"this.style.backgroundColor='#0000CC';\" onmouseout=\"this.style.backgroundColor='blue';\" onclick=\"window.location = 'people_messages.php'\"><font size=5 color=red>Messages (" . $message_num . ")</font></td>";
			}
		}
		
		if($friend_num == 0 || $userid != $_SESSION['home_user']) {
			echo "<tr><td><img src='smiley.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'friends_page.php?user=$userid'\"><font size=5>Friends</font></td>";
		} else {
			echo "<tr><td><img src='smiley.jpg' width=25px height=25px>&nbsp;&nbsp;<td style='background-color:blue;' onmouseover=\"this.style.backgroundColor='#0000CC';\" onmouseout=\"this.style.backgroundColor='blue';\" onclick=\"window.location = 'friends_page.php?user=$userid'\"><font size=5 color=red>Friends (" . $friend_num . ")</font></td>";
		}
		
		if($meeting_num == 0 || $userid != $_SESSION['home_user']) {
			echo "<tr><td><img src='calender.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'meetups.php?user=$userid'\"><font size=5>Meetups</font></td>";
		} else {
			echo "<tr><td><img src='calender.jpg' width=25px height=25px>&nbsp;&nbsp;<td style='background-color:blue;' onmouseover=\"this.style.backgroundColor='#0000CC';\" onmouseout=\"this.style.backgroundColor='blue';\" onclick=\"window.location = 'meetups.php?user=$userid'\"><font size=5 color=red>Meetups (" . $meeting_num . ")</font></td>";
		}
	

		echo "<tr><td><img src='info.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'user_page.php?user=$userid'\"><font size=5>Information</font></td>";
		if($userid != $_SESSION['home_user']) {
			echo "<tr><td><img src='buy_sell.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'buy_sell.php?user=$userid'\"><font size=5>Buy/Sell</font></td>";
		} else {

			if($product_num == 0) {
				echo "<tr><td><img src='buy_sell.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'buy_sell.php'\"><font size=5>Buy/Sell</font></td>";
			} else {
				echo "<tr><td><img src='buy_sell.jpg' width=25px height=25px>&nbsp;&nbsp;<td style='background-color:blue;' onmouseover=\"this.style.backgroundColor='#0000CC';\" onmouseout=\"this.style.backgroundColor='blue';\" onclick=\"window.location = 'buy_sell.php'\"><font size=5 color=red>Buy/Sell (" . $product_num . ")</font></td>";
			}
		}
		
		if($userid == $_SESSION['home_user']) {
			echo "<tr><td><img src='lock.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'privacy.php'\"><font size=5>Privacy</font></td>";
		}
		
		echo "<tr><td><img src='gallery.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'gallery.php?user=$userid'\"><font size=5>Photos</font></td>";
		echo "<tr><td><img src='wall.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'wall.php?user=$userid'\"><font size=5>Wall</font></td>";
		
		if($userid == $_SESSION['home_user']) {
			echo "<tr><td><img src='news_feed.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'news.php'\"><font size=5>News</font></td>";
			echo "<tr><td><img src='broadcast.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'broadcast.php'\"><font size=5>Broadcast</font></td>";
			echo "<tr><td><img src='campus_leaders.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'campus_leaders.php'\"><font size=5>Campus Leaders</font></td>";
			echo "<tr><td><img src='activities.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'activities.php'\"><font size=5>Activities</font></td>";
			
			if($invite_num == 0) {
				echo "<tr><td><img src='invite.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'invites.php'\"><font size=5>Invites</font></td>";
			} else {
				echo "<tr><td><img src='invite.jpg' width=25px height=25px>&nbsp;&nbsp;<td style='background-color:blue;' onmouseover=\"this.style.backgroundColor='#0000CC';\" onmouseout=\"this.style.backgroundColor='blue';\" onclick=\"window.location = 'invites.php'\"><font size=5 color=red>Invites (" . $invite_num . ")</font></td>";
			}
				
			echo "<tr><td><img src='handshake.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'relationships.php'\"><font size=5>Relationships</font></td>";
			
			if($alert_num == 0) {
				echo "<tr><td><img src='alert.jpg' width=25px height=25px>&nbsp;&nbsp;<td onmouseover=\"this.style.backgroundColor='#D8D8D8';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'alerts.php'\"><font size=5>Alerts</font></td>";
			} else {
				echo "<tr><td><img src='alert.jpg' width=25px height=25px>&nbsp;&nbsp;<td style='background-color:blue;' onmouseover=\"this.style.backgroundColor='#0000CC';\" onmouseout=\"this.style.backgroundColor='blue';\" onclick=\"window.location = 'alerts.php'\"><font size=5 color=red>Alerts (" . $alert_num . ")</font></td>";
			}
		}
		
		echo "</table></div>";

		echo "<td width=3%><td width=75% height=1000 valign=top>";
	} else {

		die(mysql_error()); 
	}
	
}

?>



