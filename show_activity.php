

<?php


session_start();


include('create_group.php');

include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

if($_SESSION['gender'] == 1 && $_REQUEST['id'] == 30) {
	echo "<div class='layout'><b>You Are Not Female, I'm sorry</b></div>";
	return;
}

if($_SESSION['gender'] == 0 && $_REQUEST['id'] == 31) {
	echo "<div class='layout'><b>You Are Not Male, I'm sorry</b></div>";
	return;
}

$query = "select type, image, activitytypeid, description from categories where activitytypeid=" . $_REQUEST['id'];
$result = mysql_query($query);

echo "<div class='layout' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Activity </b></font></div><p><div class='layout' >";


if($result){

	if($row = mysql_fetch_array($result)){

		echo "<center><img src='" . $row['image'] . "' width=150px height=150px></center><p><h2>Activity: " .  $row['type'] . "</h2><p>";
		echo "<table><tr><td width=20%>";
		echo "<h2>Description</h2><font size=4>" . $row['description'] . "</font>";
		
		$query = "select activity.description, activity.address, activity.image from categories, activity_category, activity where categories.type=activity_category.type and activity_category.activityid=activity.activityid and activitytypeid=" . $_REQUEST['id'];
		$result = mysql_query($query);
		
		if($result == false) {
			die(mysql_error());
		}
		
		echo "<td width=10%></table>";
		echo "<h2>Venues</h2><div style='overflow:auto; height:200px'><table>";
		
		while($row = mysql_fetch_array($result)) {
		
			echo "<tr><td><img src='" . $row['image'] . "' width=70px height=70px><td width=40%><font size=4><b>" . $row['description'] . "</b></font><td><font size=4>" . $row['address'] . "</font>";
		}
		
		echo "</table></div>";
		
	}
	
} else {
	die(mysql_error()); // useful for debug
}

if($_REQUEST['id'] == 33) {
	echo "</div><P><div class='layout'><center><b>Click <a href='blind_meetups.php'>here</a> to arrage a blind meetup</b></center></div>";
	echo "</table>";
	$db->disconnect();
	return;
}

$query = "select UNIX_TIMESTAMP(timestamp) from last_n_activities where userid=" . $_SESSION['home_user'] . " and activitytypeid=" . $_REQUEST['id'] . " order by timestamp desc limit 1";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$row = mysql_fetch_array($result);

$prev_date = date("Y-m-d", $row[0]);
$datetime1 = new DateTime($prev_date);
$datetime2 = new DateTime();
$interval = $datetime1->diff($datetime2);
$interval = intval($interval->format('%R%a'));

if( $interval < 2) {
	echo "</div><P><div class='layout'><center><b>Cannot Request This Activity For Another " . (2 - $interval) . " days</b></center></div>";
	echo "</table>";
	$db->disconnect();
	return;
}

if($_REQUEST['id'] == 34) {

	$query = "select * from user a, user b where a.relid=b.userid and b.relid=a.userid and a.userid=" . $_SESSION['home_user'];
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) == 0) {
		echo "</div><P><div class='layout'><center><b>Sorry but you have to be in mutually agreed upon relationship before you can undertake this activity. Try <a href='meetup_pool.php'>the meetup pool</a> to find your next girlfriend/boyfriend.</b></center></div>";
		echo "</table>";
		$db->disconnect();
		return;
	}
}

echo "</div><p><div class='layout'><a href='format_invite.php?id=" .  $_REQUEST['id'] . "'><center><img src='generate_invite1.jpg' onmouseover='this.src=\"generate_invite2.jpg\"' onmouseout='this.src=\"generate_invite1.jpg\"'></center></a></div>";


?>


</table>

<?php

$db->disconnect(); // disconnect after use is a good habit

?>