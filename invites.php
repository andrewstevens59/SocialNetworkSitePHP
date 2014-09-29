<div id='new_page'>

<?php

session_start();


include('connectMySQL.php'); 

$query = "update alerts set invites=0 where userid=" . $_SESSION['home_user'];
$tmp = mysql_query($query);

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

function drawAlerts($result, $hover, $new) {

	if($new == 1) {
		echo "<div class='layout' style='border: 2px solid red'><table>";
	} else {
		echo "<div class='layout'><table>";
	}
	
	while($row = mysql_fetch_array($result)){
	
		echo "<tr>";
		if($row['accept'] == 1) {
			echo "<td><img src='tick.jpg' width=30px height=30px>";
		} else if($row['accept'] == 4) {
			echo "<td><img src='change_details.jpg' width=30px height=30px>";
		} else if($row['accept'] == 5) {
			echo "<td><img src='ask.jpg' width=30px height=30px>";
		}  else if($row['accept'] == 3) {
			echo "<td><img src='invite_message.jpg' width=30px height=30px>";
		}  else if($row['accept'] == 2) {
			echo "<td><img src='maybe.jpg' width=30px height=30px>";
		} else {
			echo "<td><img src='sorry.jpg' width=30px height=30px>";
		}
		
		if($row['accept'] != 5) {
			$highlight = "$hover onclick=\"window.location = 'show_invite.php?user=" . $row ['meetupid'] . "'\"";
		} else {
			$highlight = "";
		}
	
		if($row['activitytypeid'] != 33 && $row['activitytypeid'] != 32) {
			echo "<td><a href='user_page.php?user=" . $row['userid'] . "'><img src='" . $row['thumb'] . "' height=70px width=70px></a><td width=45% $highlight><b><a href='user_page.php?user=" . $row['userid'] . "'>" . $row['firstname'] . " " . $row['surname'] . "</a></b>";
		} else {
			echo "<td><img src='activities/question_mark.jpg' height=70px width=70px><td width=45% $highlight><b>" . $row['firstname'] . "</b>";
		}
		
		if($row['accept'] == 1) {
		} else if($row['accept'] == 4) {
			echo "<br><font color='purple'> <b>changed the details</b></font>";
		} else if($row['accept'] == 2) {
			echo "<br><font color='#FF8C00'> <b>is considering going</b></font>";
		} else if($row['accept'] == 5) {
			echo "<br><font color='	#DAA520'> <b>is interested in this activity <br><a href='' onclick='reloadPage(\"invite_person.php\", \"user=" . $row['userid'] . "&id=" . $row['meetupid'] . "\", \"invites.php\", \"new_page\");return false;'>click <font color='red'>here</font> to invite them</a></b></font>";
		}  else if($row['accept'] == 0) {
			echo "<br><font color='red'> <b>sorry, can't make it</b></font>";
		}
		
		if($row['accept'] == 3) {
			$query = "select message from invite_message where messageid=" . $row['messageid'];
			$result5 = mysql_query($query);
			$message = mysql_fetch_array($result5);
			echo "<br>" . $message[0];
		}
		
		echo "<td><img src='arrow.jpg' width=10px height=10px><td width=2%>";
		
		echo "<td><a href='show_activity.php?id=" . $row['activitytypeid'] . "'><img src='" . $row [10] . "' height=70px width=70px></a>";
		echo "<td width=2%><b><a href='show_activity.php?id=" . $row['activitytypeid'] . "'>" .$row ['type'] . "</a></b>";
		echo "<td><img src='arrow.jpg' width=10px height=10px><td width=2%>";
		echo "<td width=100% $hover onclick=\"window.location = 'show_invite.php?user=" . $row ['meetupid'] . "'\"><table><tr>";
		
		echo "<td><a href='show_invite.php?user=" . $row['meetupid'] . "'><img src='" . $row[9] . "' height=70px width=70px></a><td><b>" . $row['description'];
		echo " <br><font color='blue'>" . date("h:i a", strtotime($row['time'])) . " " . date("(l dS \of F)", $row[0]) ."</font></b></table>";
	}
	
	echo "</table></div><p>";
}

$query = "select UNIX_TIMESTAMP(date_recorded), time, messageid, user.userid, thumb, firstname, surname, invite_updates.accept, meetups.meetupid, activity.image, categories.image, activity.description, meetups.activitytypeid, categories.type from user, invite_updates, meetups, activity, categories, invites where invite_updates.userid=user.userid and invites.meetupid=meetups.meetupid and categories.activitytypeid=meetups.activitytypeid and activity.activityid=meetups.activityid and meetups.meetupid=invite_updates.meetupid and invites.userid=" . $_SESSION['home_user'] . " and invite_updates.timestamp > '" . $_SESSION['last_login'] . "' order by invites.timestamp desc limit 50";
$result1 = mysql_query($query);

if($result1 == false) {
	die(mysql_error());
}

$query = "select UNIX_TIMESTAMP(date_recorded), time, messageid, user.userid, thumb, firstname, surname, invite_updates.accept, meetups.meetupid, activity.image, categories.image, activity.description, meetups.activitytypeid, categories.type from user, invite_updates, meetups, activity, categories, invites where invite_updates.userid=user.userid and invites.meetupid=meetups.meetupid and categories.activitytypeid=meetups.activitytypeid and activity.activityid=meetups.activityid and meetups.meetupid=invite_updates.meetupid and invites.userid=" . $_SESSION['home_user'] . " and invite_updates.timestamp <= '" . $_SESSION['last_login'] . "' order by invites.timestamp desc limit 50";
$result4 = mysql_query($query);
if($result4 == false) {
	die(mysql_error());
}

$query = "select UNIX_TIMESTAMP(date_recorded), time, userid, time, activity.description, activity.image, activity.activityid, meetups.meetupid, categories.image, categories.type, categories.activitytypeid from invites, meetups, activity, categories where categories.activitytypeid=meetups.activitytypeid and accept=0 and invites.meetupid=meetups.meetupid and meetups.activityid=activity.activityid and invites.timestamp > '" . $_SESSION['last_login'] . "' and invites.userid=" . $_SESSION['home_user'] . " order by meetups.date_recorded desc limit 50";
$result2 = mysql_query($query);
if($result2 == false) {
	die(mysql_error());
}

$query = "select UNIX_TIMESTAMP(date_recorded), time, userid, time, activity.description, activity.image, activity.activityid, meetups.meetupid, categories.image, categories.type, categories.activitytypeid from invites, meetups, activity, categories where categories.activitytypeid=meetups.activitytypeid and accept=0 and invites.meetupid=meetups.meetupid and meetups.activityid=activity.activityid and invites.timestamp <= '" . $_SESSION['last_login'] . "' and invites.userid=" . $_SESSION['home_user'] . " order by meetups.date_recorded desc limit 20";
$result3 = mysql_query($query);
if($result3 == false) {
	die(mysql_error());
}


if(mysql_num_rows($result1) > 0) {
	echo "<div class='layout'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> New Alerts (" . mysql_num_rows($result1) . ") </b></font></div><p>";
	drawAlerts($result1, $hover, 1);
}


if(mysql_num_rows($result2) > 0) {
	echo "<div class='layout'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> New Invites (" . mysql_num_rows($result2) . ") </b></font></div><p>";
	
	echo "<div class='layout'  style='border:2px solid red'><table>";
	while($row = mysql_fetch_array($result2)){
		echo "<tr>";
		echo "<td><a href='show_activity.php?id=" . $row['activitytypeid'] . "'><img src='" . $row [8] . "' height=70px width=70px></a>";
		echo "<td width=15%><b><a href='show_activity.php?id=" . $row['activitytypeid'] . "'>" .$row ['type'] . "</a></b>";
		echo "<td><img src='arrow.jpg' width=10px height=10px><td width=2%>";
		echo "<td width=100% $hover onclick=\"window.location = 'show_invite.php?user=" . $row ['meetupid'] . "'\"><table><tr>";
		echo "<td><img src='" . $row [5] . "' height=70px width=70px>";
		echo "<td><b>" .$row ['description'];
		echo "<br><font color='blue'>" . date("h:i a", strtotime($row['time'])) . " " . date("(l dS \of F)", $row[0]) ."</font></b>";
		echo "</table><td>";
	}
	
	echo "</table></div><p>";
}


echo "<div class='layout' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Existing Invites (" . mysql_num_rows($result3) . ") </b></font></div><p>";

if(mysql_num_rows($result3) > 0) {
	echo "<div class='layout'>";
	
	echo "<table>";
	while($row = mysql_fetch_array($result3)){
		echo "<tr>";
		echo "<td><a href='show_activity.php?id=" . $row['activitytypeid'] . "'><img src='" . $row [8] . "' height=70px width=70px></a>";
		echo "<td width=15%><b><a href='show_activity.php?id=" . $row['activitytypeid'] . "'>" .$row ['type'] . "</a></b>";
		echo "<td><img src='arrow.jpg' width=10px height=10px><td width=2%>";
		echo "<td width=100% $hover onclick=\"window.location = 'show_invite.php?user=" . $row ['meetupid'] . "'\"><table><tr>";
		echo "<td><img src='" . $row [5] . "' height=70px width=70px>";
		echo "<td><b>" .$row ['description'];
		echo "<br><font color='blue'>" . date("h:i a", strtotime($row['time'])) . " " . date("(l dS \of F)", $row[0]) ."</font></b>";
		echo "</table><td>";
	}

	echo "</table></div>";
}

if(mysql_num_rows($result4) > 0) {
	echo "<p><div class='layout'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Existing Alerts (" . mysql_num_rows($result4) . ") </b></font></div><p>";
	drawAlerts($result4, $hover, 0);
}


$db->disconnect(); // disconnect after use is a good habit


?>

</div>