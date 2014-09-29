<?php


session_start();

include('connectMySQL.php'); 


include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$query = "select UNIX_TIMESTAMP(date_recorded), time, userid, time, activity.description, activity.image, categories.image, activity.activityid, meetups.meetupid, categories.activitytypeid, type from invites, meetups, activity, categories where categories.activitytypeid=meetups.activitytypeid and invites.meetupid=meetups.meetupid and meetups.activityid=activity.activityid and (categories.type='date set up' or categories.type='dating' or categories.type='group date' or categories.type='indv meetup') and invites.userid=" . $_SESSION['home_user'] . " and date_recorded >= DATE_SUB(NOW(), INTERVAL 0 DAY) order by meetups.date_recorded desc limit 7";
$result3 = mysql_query($query);

echo "<div class='layout' style='width:90%'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Relationships </b></font></div><p>";

echo "<div class='layout'><center><div style='background-color:#F2F2F2'><font size=5>Do you want to meet more people outside your usual circle of close friends, meetups help you to do this.</font></div></center><p>";

echo "<div style='background-color:#F2F2F2'><table><tr><td><a href='blind_meetups.php'><img src='view1.jpg' onmouseover='this.src=\"view2.jpg\"' onmouseout='this.src=\"view1.jpg\"'></a><td width=40%><td><font size=6><b>Blind Meetups</b></font></div><p>";

echo "<tr><td><tr><td><tr><td><a href='individual_meetups.php'><img src='view1.jpg' onmouseover='this.src=\"view2.jpg\"' onmouseout='this.src=\"view1.jpg\"'></a><td width=40%><td><font size=6><b>Individual Meetups</b></font></div><p>";

echo "<tr><td><tr><td><tr><td><a href='meetup_pool.php'><img src='view1.jpg' onmouseover='this.src=\"view2.jpg\"' onmouseout='this.src=\"view1.jpg\"'></a>";

$query = "select * from meetup_pool where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); // useful for debug
}

if(mysql_num_rows($result) > 0) {
	echo "&nbsp;&nbsp;<a href='search_pool.php'><img src='browse1.jpg' onmouseover='this.src=\"browse2.jpg\"' onmouseout='this.src=\"browse1.jpg\"'></a>";
}

echo "<td width=40%><td><font size=6><b>Meetup Pool</b></font></table></div></div><p>";


if($result3){


	if(mysql_num_rows($result3) > 0) {
		echo "<div class='layout' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Existing Invites (" . mysql_num_rows($result3) . ") </b></font></div><p>";
		echo "<div class='layout'>";
		
		echo "<table>";
		while($row = mysql_fetch_array($result3)){
			echo "<tr>";
			echo "<td><a href='show_activity.php?id=" . $row['activitytypeid'] . "'><img src='" . $row [6] . "' height=70px width=70px></a>";
			echo "<td width=15%><b><a href='show_activity.php?id=" . $row['activitytypeid'] . "'>" .$row ['type'] . "</a></b>";
			echo "<td><img src='arrow.jpg' width=10px height=10px><td width=2%>";
			echo "<td width=100% $hover onclick=\"window.location = 'show_invite.php?user=" . $row ['meetupid'] . "'\"><table><tr>";
			echo "<td><img src='" . $row [5] . "' height=70px width=70px>";
			echo "<td><b>" .$row ['description'] . "<br>";
			echo "<font color='blue'>" . date("h:i a", strtotime($row['time'])) . " " . date("(l dS \of F)", $row[0]) ."</font></b>";
			echo "</table><td>";
		}
	
		echo "</table></div>";
	}

} else {
	die(mysql_error()); // useful for debug
}

echo "</table></table>";


$db->disconnect(); // disconnect after use is a good habit


?>