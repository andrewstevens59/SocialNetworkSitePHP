<div id='new_page'>

<div id="big_alert" style="border: 20px outset blue ; background-color: rgb(255, 255, 255); z-index:100; top:100px; width:44%; height:300px; left:30%; display:none; background-color:#E6E6FA; overflow:auto;  position: absolute;" onmouseover='is_set=true;' onmouseout='is_set=false;'></div>

<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>

<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />

<script type='text/javascript'>

	function showActivities() {
		document.getElementById("big_alert").innerHTML = activities;
		document.getElementById("big_alert").style.display = "block";
		document.getElementById("big_alert").style.top = tempY;
		document.getElementById("big_alert").style.left = tempX - 200;
	}
	
	function showSave() {
		document.getElementById("save").style.display = "block";
	}
	
</script>

<?php

function drawInviteSet($result, $is_blind_date, $activitytypeid, $accept_date, $userid, $hover) {

	$count = 0;
	$prev_gender = -1;
	
	if($activitytypeid == 32) {
		// group date
		$query = "select questions from user where userid=" . $_SESSION['home_user'];
		$tmp = mysql_query($query);
		$user_row = mysql_fetch_array($tmp);
	}

	while($row = mysql_fetch_array($result)){

		if($row['gender'] != $prev_gender) {
			if($prev_gender >= 0) {
				echo "</table></div><hr color='#E6E6FA'>";
			}
			
			if($row['gender'] == 1) {
				echo "<font size=5><b>Boys</b></font>";
			} else {
				echo "<font size=5><b>Girls</b></font>";
			}
			
			$prev_gender = $row['gender'];
			echo "<div style='background-color:#F2F2F2;'><table>";
			$count = 0;
		}
	
		if($count == 0) {
			echo "<tr>";
		}
			
		echo "<td>";
		
		if($is_blind_date != 1 || $row['userid'] == $userid) {
			echo "<table $hover onclick='showInvites(" . $row['userid'] . ");return false;'><tr><td><a href='user_page.php?user=" . $row ['userid'] . "'> <img src='" . $row['thumb'] . "' width=70px height=70px></a><td><font size=4><a href='user_page.php?user=" . $row ['userid'] . "'><b>" . $row['firstname'] . " " . $row['surname'] . "</b></a></font></table>";
		} else {
			echo "<img src='activities/question_mark.jpg' width=70px height=70px><td><font size=4><b>" . $row['firstname'];
			
			if($activitytypeid == 32) {
				// group date
				$prev_date = date("Y-m-d", $row[0]);
				$datetime1 = new DateTime($prev_date);
				$datetime2 = new DateTime();
				$interval = $datetime1->diff($datetime2);
					
				echo ", " . $interval->y . "</b></font> <br>";
				calculateMatch($user_row[0], $row['questions'], 1);
			} else {
				echo "</b></font>";
			}
		}
		
		if($activitytypeid == 36 && $row['userid'] != $userid && $accept_date == false) {
			// date set up don't want the other person to know
			echo "<td>";
		} else if($row['accept'] == 1) {
			echo "<td><center><img src='tick.jpg' width=30px height=30px></center>";
		} else if($row['accept'] == 2) {
			echo "<td><center><img src='maybe.jpg' width=30px height=30px></center>";
		} else {
			echo "<td>";
		}
		
		echo "<td width=3%>";
		
		$count = $count + 1;
		if($count >= 3) {
			$count = 0;
		}
	}
	
	echo "</table></div><p>";
}


session_start();

include('connectMySQL.php'); 

$meetupid = $_REQUEST['user'];

$userid = $_SESSION['home_user'];
if(isset($_REQUEST['id']) == true) { 
	$userid = $_REQUEST['id'];
} 

include('banner.php');
drawBanner(false, $userid);

include('check_privacy.php');
checkAccessRights($userid, "meetups");

$query = "update alerts set invites=0 where userid=$userid";
$tmp = mysql_query($query);

$query = "select UNIX_TIMESTAMP(date_recorded), date_recorded, time, type, meetups.activitytypeid, image, type from categories, meetups where meetups.meetupid=$meetupid and meetups.activitytypeid=categories.activitytypeid";
$result = mysql_query($query);

if($result == false){
	die(mysql_error());
}

$activityrow = mysql_fetch_array($result);

$query = "select firstname, surname from user where userid=$userid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$username = $row['firstname'] . " " . $row['surname'];

if(isset($_REQUEST['activity']) == false) {
	$query = "select meetup, address, activity.description, activity.image, activity.activityid from activity, meetups where activity.activityid=meetups.activityid and meetups.meetupid=$meetupid";
} else {
	$query = "select meetup, address, activity.description, activity.image, activity.activityid from activity where activity.activityid=" . $_REQUEST['activity'];
}

$result = mysql_query($query);
$is_blind_date = 0;
$is_accept_invite = true;

if($result){


	$row = mysql_fetch_array($result);
	
	echo "<input type='text' id='date_set' style='display:none;' value='" . $activityrow['date_recorded'] . "'>";
	
	echo "<div class='layout'><b><font size=6>$username <img src='arrow.jpg' width=20px height=20px> " . $row['description'] . " </b></font></div><p>";
	
	echo "<div class='layout'>";
	echo "<center><table><tr><td><img src='" . $activityrow['image'] . "' width=90px height=90px><td><h1>" . $activityrow['type'] . "</h1><td width=10%><td><img src='arrow.jpg' width=20px height=20px><td width=10%><td><a href='" . $row['image'] . "' rel='lightbox[album]'><img src='" . $row['image'] . "' width=90px height=90px><td width=3%></a><td><h1>" . date("h:i a", strtotime($activityrow['time'])) . "</h1></table></center><p>";
	
	echo "<font size=6>Dear <b>$username</b><p><table><tr><td width=10%><td><font size=5>";
	$activitytypeid = $activityrow['activitytypeid'];


	if($activityrow['activitytypeid'] == 36) {
		echo "You have been set up on a date<p>";
		$is_blind_date = 2;
	} else if($activityrow['activitytypeid'] == 32) {
		echo "You have been envited to go on a group date<p>";
		$is_blind_date = 1;
	} else if($activityrow['type'] == 'indv meetup') {
		echo "You have been envited to meet up with a <b>mystery person</b><p>";
		$is_blind_date = 1;
	} else {
		echo "You have been envited to meet up with some of your friends<p>";
	}
	
	echo "<div class='layout' style='background-color:#F2F2F2;'><form action=\"save_activity_details.php?id=$meetupid\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<input type='text' name='activity' style='display:none;' value='" . $row['activityid'] . "'>";
	
	echo "<b>Activity:</b> ";
	
	$query = "select activity.activityid, activity.description, activity.image, activity.address from categories, activity_category, activity where activity.activityid=activity_category.activityid and categories.type=activity_category.type and categories.activitytypeid=" . $activityrow['activitytypeid'];
	$result = mysql_query($query);
	
	$activity_str = "<table>";

	if($result){

		while($row1 = mysql_fetch_array($result)){
			$activity_str .= "<tr><td><table $hover onclick='reloadPage(\"\", \"\", \"show_invite.php?user=$meetupid&activity=" . $row1['activityid'] . "\", \"new_page\");return false;'><tr><td><img src='" . $row1['image'] . "' width=70px height=70px><td width=40%><font size=4><b>" . $row1['description'] . "</b></font><td><font size=4>" . $row1['address'] . "</font></table>";
		}
	} else {
		die(mysql_error());
	}
	
	$activity_str .= "</table>";
	echo "<script type='text/javascript'>activities=\"" . mysql_real_escape_string($activity_str) . "\";</script>";
	
	echo "<a href='' onclick='showActivities();return false;'>" . $row['description'] . "</a><p>";
	echo "<center><font size=2><a href='remove_activity_type.php?id=$meetupid&activity=" . $activityrow['activitytypeid'] . "'>Don't Suggest This Activity Type Again</a></font></center>";
	
	echo "<hr color='white' size=4><b>Location:</b> " . $row['address'];
	echo "<br><hr color='white' size=4><b>Where to meet: </b>" . $row['meetup'];
	echo "<br><hr color='white' size=4><b>Time/Date:</b> ";

	echo "<FONT SIZE=\"7\"><select name=\"time\" size=\"1\" onchange='showSave();'>";
	
	echo "<option value='" . $activityrow['time'] . "'>" . date("h:i a", strtotime($activityrow['time']));
	
	for($i=8; $i<24; $i++) {
		$time = $i;
		
		if($i < 13) {
			echo "<option value='" . $i . ":00'><FONT SIZE=7>$time:00 am</font>";
		} else {
			$time -= 12;
			echo "<option value='" . $i . ":00'>$time:00 pm";
		}
	}
	
	$tmp = date("Y-m-d", $activityrow[0]);
	$date = date("Y-m-d", strtotime($tmp . " +1 days"));
	echo "</select></font> " . date("(l dS \of F Y)", strtotime($tmp . " +1 days")) . " </font>";
	
	$accept_date = false;
	if($userid == $_SESSION['home_user']) {
	
		if(isset($_REQUEST['activity']) == true) {
			echo "<p><input type=\"image\" VALUE=\"Submit\" src='save1.jpg' onmouseover='this.src=\"save2.jpg\"' onmouseout='this.src=\"save1.jpg\"'>";
		} else {
			echo "<p><input type=\"image\" id='save' style='display:none;'	VALUE=\"Submit\" src='save1.jpg' onmouseover='this.src=\"save2.jpg\"' onmouseout='this.src=\"save1.jpg\"'>";
		}
		
		echo "</div><p></table>";
	
		$query = "select accept, person_count from invites where meetupid=$meetupid and invites.accept!=0 and invites.userid=$userid";
		$result = mysql_query($query);
		
		if(mysql_num_rows($result) == 0) {
			
			if($activitytypeid != 36) {
				echo "<font size='3'><center><a href='accept_invite.php?user=$meetupid'><img src='accept1.jpg' onmouseover='this.src=\"accept2.jpg\"' onmouseout='this.src=\"accept1.jpg\"'></a>";
				echo "&nbsp;&nbsp;<a href='decline_invite.php?user=$meetupid'><img src='decline1.jpg' onmouseover='this.src=\"decline2.jpg\"' onmouseout='this.src=\"decline1.jpg\"'></a></center>";
				echo "<center><font color='red'>(You must accept or decline an invite to let others know your intentions)</font></center>";
			} else {
				echo "<font size='3'><center><a href='accept_invite.php?user=$meetupid&status=2'><img src='accept1.jpg' onmouseover='this.src=\"accept2.jpg\"' onmouseout='this.src=\"accept1.jpg\"'></a>";
				echo "<center><font color='blue'>(Don't worry, you're accept status is hidden from the other person. A meetup will only be scheduled when both sides have accepted. So they'll never know that you accepted when they didn't. So you have nothing to lose by accepting...)</font></center></div>";
			}
			$is_accept_invite = false;
		} else {
			
			if($row['accept'] == 1) {
				echo "<font size='3'><center><font color='green'>(You have accepted this invite, it's impolite not to go once you've accepted)</font></center></font>";
			} else {
				echo "<font size='3'><center><font color='green'>(You have agreed to go if " . $row['person_count'] . " other people go including yourself)</font></center></font>";
			}
			
			$row = mysql_fetch_array($result);
			if($activitytypeid == 36 && $row['accept'] == 1) {
				// both sides have accepted the date
				$accept_date = true;
				echo "<font size='4'><center><font color='#FF6600'><b>You both have accepted the date!!</b> You kids have fun now!</font></center></font>";
			}	
		}
		
	} else {
		echo "</table>";
	}
		
	echo "</font></form></div><P>";
	
	
	if($userid == $_SESSION['home_user']) {
		$query = "select UNIX_TIMESTAMP(date_recorded), time, activity.description, meetups.meetupid, activity.image, categories.image, type, categories.activitytypeid, invites.accept from invites, meetups, activity, categories where meetups.meetupid!=$meetupid and meetups.date_recorded like '$date' and categories.activitytypeid=meetups.activitytypeid and invites.meetupid=meetups.meetupid and meetups.activityid=activity.activityid and invites.userid=$userid order by time asc limit 0,50";
		$result = mysql_query($query);

		if($result == false){
			die(mysql_error());
		}

		if(mysql_num_rows($result) > 0) {

			echo "<P><div class='layout'><center><font size=5><b>Your Meetups On The Same Day</b></font></center><table>";

			while($row = mysql_fetch_array($result)){
				
				echo "<tr>"; 
				echo "<td><a href='show_activity.php?id=" . $row['activitytypeid'] . "'><img src='" . $row [5] . "' height=70px width=70px></a>";
				echo "<td width=15%><b><a href='show_activity.php?id=" . $row['activitytypeid'] . "'>" . mysql_real_escape_string($row ['type']) . "</a></b>";
				echo "<td><img src='arrow.jpg' width=10px height=10px><td width=2%>";
				
				if($row['accept'] == 1) {
					echo "<td><center><img src='tick.jpg' width=30px height=30px></center>";
				} else if($row['accept'] == 2) {
					echo "<td><center><img src='maybe.jpg' width=30px height=30px></center>";
				} else {
					echo "<td><center><img src='mail.jpg' width=30px height=30px></center>";
				}
				
				echo "<td width=100% $hover onclick=\"window.location = 'show_invite.php?user=" . $row ['meetupid'] . "'\"><table><tr>";
				echo "<td><img src='" . $row [4] . "' height=70px width=70px>";
				echo "<td><b>" .$row ['description'] . "<br><font color='blue'>" . date("h:i a", strtotime($row['time']));
				echo "</b></font></table><td>";
			}

			echo "</table></div><p>";
		}
	} else if($is_blind_date == 0) {
	
		$query = "select * from invites where meetupid=$meetupid and userid=" . $_SESSION['home_user'];
		$result = mysql_query($query);

		if($result == false){
			die(mysql_error());
		}
	
		if(mysql_num_rows($result) == 0) {
			$query = "select * from invite_updates where meetupid=$meetupid and userid=" . $_SESSION['home_user'] . " and accept=5";
			$result = mysql_query($query);

			if($result == false){
				die(mysql_error());
			}

			if(mysql_num_rows($result) > 0) {
				echo "<P><div class='layout'><center>You will be invited to attend this activity if someone in the current group invites you.</center></div><p>";
			} else {
				echo "<P><div class='layout'><center><table><tr><td><font size=4>Would you like to be invited to this activity</font><td width=2%><td><a href='request_invite.php?user=$userid&id=$meetupid'><img src='yes1.jpg' onmouseover='this.src=\"yes2.jpg\"' onmouseout='this.src=\"yes1.jpg\"'></a><td width=2%><td><a href='meetups.php?user=$userid'><img src='no1.jpg' onmouseover='this.src=\"no2.jpg\"' onmouseout='this.src=\"no1.jpg\"'></a></table></center></div><p>";
			}
		}
	}
	
	if($is_blind_date == 0) {
		echo "<div class='layout'><center><font size=5><b>Friends Invited</b></font></center><p>";
		$query = "select UNIX_TIMESTAMP(user.dob), user.userid, firstname, surname, thumb, accept, user.gender from user, meetups, invites where user.userid=invites.userid and invites.meetupid=meetups.meetupid and meetups.meetupid=$meetupid and exists (select userid2 from friends where userid1=$userid) order by gender, accept desc";
	} else {
		if($is_blind_date == 1) {
		
			if($activitytypeid == 34) {
				echo "<div class='layout'><center><font size=5><b>Your meetup is with </b></font></center><p>";
			} else {
				echo "<div class='layout'><center><font size=5><b>Your Next Girlfriend/Boyfriend </b></font></center><p>";
			}
			
		} else {
			echo "<div class='layout'><center><font size=5><b>You're going on a date with... </b></font><br><font size=3 color='blue'></center><p>Don't worry you're accept or decline status is hidden from the other person, they will never know if you accepted or declined. A meetup will only be scheduled when you both have accepted.</font><p>";
		}
		
		$query = "select UNIX_TIMESTAMP(user.dob), user.userid, questions, firstname, surname, thumb, accept, user.gender from user, meetups, invites where user.userid=invites.userid and invites.meetupid=meetups.meetupid and meetups.meetupid=$meetupid order by gender, accept desc";
	}	

	$result = mysql_query($query);
	$friend_num = mysql_num_rows($result);
	drawInviteSet($result, $is_blind_date, $activitytypeid, $accept_date, $userid, $other_hover);
	
	if($is_blind_date == 0) {
		$query = "select UNIX_TIMESTAMP(user.dob), user.userid, questions, firstname, surname, thumb, accept, user.gender from user, meetups, invites where user.userid=invites.userid and invites.meetupid=meetups.meetupid and meetups.meetupid=$meetupid and not exists (select userid2 from friends where userid1=$userid) order by gender, accept desc";
		$result = mysql_query($query);
		
		if(mysql_num_rows($result) > 0) {
			echo "<div class='layout'><center><font size=5><b>Meet New People</b></font></center><p>";
			$friend_num += mysql_num_rows($result);
			drawInviteSet($result, $is_blind_date, $activitytypeid, $accept_date, $userid, $other_hover);
		}
	} 
	
	if($is_blind_date == 0 && $userid == $_SESSION['home_user']) {
		echo "<center><font size=4><b>(Invite A Friend)</b></font><table><tr>";
		echo "<form ACTION=\"search.php?type=1&user=$userid\" METHOD=POST autocomplete=\"off\">";
		
		?>
		<td align="right"><input type="text" style="height: 35px;font-size:20px;" name="search" size="70" onkeyup="showSearchRes('friends_page', this.value, 4, 5, <?php echo $meetupid  ?>); ">
		<td width=15% halign=left><input type="image" VALUE="Search" src='search1.jpg' onmouseover='this.src="search2.jpg"' onmouseout='this.src="search1.jpg"'>
		<tr><td colspan="2"><div id="friends_page"></div>

		</form></table></center>
		<?php
	
	}

	echo "</div>";
	
} else {
	die(mysql_error()); // useful for debug
}

if($userid != $_SESSION['home_user']) {
	echo "</table>";
	$db->disconnect(); 
	return;
}

$query = "select thumb, firstname, surname, message, user.userid from invite_message, user where user.userid=invite_message.userid and invite_message.meetupid=$meetupid order by timestamp desc";
$result = mysql_query($query);

if($result){

	
	echo "<p><div class='layout'><center><font size=5><b>Messages</b></font></center><p>";
	echo "<center><font size=2><b>(Post a Message)</b></font><table><tr>";
	echo "<td><textarea id=\"message\" rows=1 cols=75 onkeyup=\"resizeTextarea(this)\" onmouseup=\"resizeTextarea(this)\"></textarea>";
	echo "<td><a href='' onclick='reloadPage(\"send_invite_message.php\", \"user=$meetupid&message=\" + document.getElementById(\"message\").value, \"show_invite.php?user=$meetupid\", \"new_page\");return false;'><img src='post1.jpg'  onmouseover='this.src=\"post2.jpg\"' onmouseout='this.src=\"post1.jpg\"'></a></table></center>";

	echo "<div style='background-color:#F2F2F2'>";

	while($row = mysql_fetch_array($result)){
	
		echo "<div>";
		echo "<table><tr>";
		
		if($is_blind_date != 1 || $row['userid'] == $userid) {
			echo "<td><a href='user_page.php?user=". $row['userid'] . "'><img src='" . $row ['thumb'] . "' height=70px width=70px></a>";
			echo "<td><b><a href='user_page.php?user=". $row['userid'] . "'>" .$row ['firstname'] . " " . $row ['surname'] ."</a></b> ";
			if($is_blind_date == 1) {
				echo "<i>(Your ID is hidden from the other person)</i><br>";
			}
		} else {
			echo "<td><img src='activities/question_mark.jpg' width=70px height=70px><td><b>" . $row['firstname'] . "</b><br>";
		}
		
		echo "<br>" . $row ['message'];
		echo "</table></div><hr color='white'>";
	}

	echo "</div></div>";


} else {
	die(mysql_error()); 
}

if($is_accept_invite == true || $friend_num < 3) {
	$db->disconnect(); 
	return;
}

echo "<p>";

$query = "select highschool, university, employers, thumb, image, firstname, surname, description, degree, status, interestedin, courses, userid from user where userid=$userid";
$result = mysql_query($query);

if($result){

echo "<div class='layout'><font size=6><b>I will go only if ...</b></font><p>";
		
	if($row = mysql_fetch_array($result)){

echo "<p><form action=\"accept_invite.php?user=$meetupid\" method=\"post\" enctype=\"multipart/form-data\">";

?>
<legend></legend>

<table>

<tr>
<td width=10%><td><label for="status"><b>This many people go (including myself)</b></label>
<td width=10%><td><select name="status" size="1">

<?php

echo "<option value='3'>3";
for($i=2; $i<=$friend_num; $i++) {
	echo "<option value='$i'>$i";
}

?>

</select><td width=10%><td><input type="image" VALUE="Submit" src='save1.jpg' onmouseover='this.src=\"save2.jpg\"' onmouseout='this.src=\"save1.jpg\"'>

</table>
</fieldset>
</form>



<?php

}
} else {

	die(mysql_error()); 
}

$db->disconnect(); 

echo "</div></table>";

?>

</div>