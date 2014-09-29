<?php


session_start();

include('connectMySQL.php'); 

$userid = $_REQUEST['user'];
$date = $_REQUEST['date'];
$is_access = true;



if($userid != $_SESSION['home_user']) {
	$query = "select meetups from privacy where userid=$userid";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);

	if($row[0] == 0) {
		// for private viewing
		$is_access = false;
	} else if($row[0] != 2) {

		$query = "select * from friends where userid1=$userid and userid2=" . $_SESSION['home_user'];
		$result = mysql_query($query);

		if(mysql_num_rows($result) == 0) {
			$is_access = false;
		}
	}
}

include('banner.php');
$query = "select date_recorded, time, activity.description, meetups.meetupid, activity.image, categories.image, type, categories.activitytypeid, invites.accept, invites.userid from invites, meetups, activity, categories where meetups.date_recorded = '$date' and categories.activitytypeid=meetups.activitytypeid and invites.meetupid=meetups.meetupid and meetups.activityid=activity.activityid and invites.userid=$userid order by time asc limit 0,50";
$result = mysql_query($query);

if($result == false){
	die(mysql_error());
}

if($is_access == false) {
	echo "<center><b>You don't have access rights to view all information</b></center><p>";
}


if(mysql_num_rows($result) > 0) {

	while($row = mysql_fetch_array($result)){
		
		if($is_access == true) {
			echo "<div $hover onclick=\"window.location = 'show_invite.php?user=" . $row ['meetupid'] . "&id=" . $row['userid']. "'\"><table><tr><td>";
			echo "<img src=\"" . $row [4] . "\" height=70px width=70px><td><b>" . $row ['description'] . "<br>";
		} else {
			echo "<div><table><tr><td>";
			echo "<img src=\"activities/question_mark.jpg\" height=70px width=70px><td>";
		}
		
		echo "<font color=blue><b>Time " . date("h:i a", strtotime($row['time'])) ."</font></b><td width=3%>";
		
		if($row['accept'] == 1) {
			echo "<td><center><img src='tick.jpg' width=30px height=30px></center>";
		} else if($row['accept'] == 2) {
			echo "<td><center><img src='maybe.jpg' width=30px height=30px></center>";
		} else {
			echo "<td><center><img src='mail.jpg' width=30px height=30px></center>";
		}
		
		echo " " . $row['date_recorded'];
		
		echo "</table></div>";
	}
} else {
	echo "<center><b>This person doesn't currently have any invites on this day</b></center>";
}
		
$db->disconnect(); 



?>