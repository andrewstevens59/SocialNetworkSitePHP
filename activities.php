

<?php


session_start();

function displayDescription($type) {

	if($type != 'adult') {
		return $type;
	}
	
	return $type . "<br> <font color='red' size=0>Meetup does not endorse or recommend this activity, however we do respect you right to freedom of choice and is included for that reason (18+ only)</font>";
}

include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$query = "select type, image, activitytypeid from categories where not exists (select activitytypeid from user_reject_activity where userid=" . $_SESSION['home_user'] . " and categories.activitytypeid=user_reject_activity.activitytypeid)";
$result = mysql_query($query);

echo "<table><tr><td><div class='layout' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Activities </b></font></div><p><div class='layout' >";

echo "<form action=\"save_activities.php\" method=\"post\" enctype=\"multipart/form-data\">";

echo "<div style='background-color:#F2F2F2'><p><center><h3>Activities You Would Like To Do</h3></center><table color='#E6E6FA'>";
if($result){
	$count = 4;
	while($row = mysql_fetch_array($result)){
	
		if($row['type'] != 'adult' || $_SESSION['gender'] == 1) {
			if($count >= 4) {
				echo "<tr>";
				$count = 0;
			}
		
			$count = $count + 1;
			echo "<td  width=2%><input type='checkbox' name='" . $row['activitytypeid'] . "' checked><td width=2%><a href='show_activity.php?id=" . $row['activitytypeid']. "'><img src='" . $row['image'] . "' width=70px height=70px></a><td width=12%><b><a href='show_activity.php?id=" . $row['activitytypeid']. "'>" .  displayDescription($row['type']) . "</a></b>";
		}
	}
	
} else {
	die(mysql_error()); // useful for debug
}

for($i=$count; $i<=4; $i++) {
	echo "<td>";
}

echo "</table></div><hr color='#E6E6FA'>";

$query = "select type, image, activitytypeid from categories where exists (select activitytypeid from user_reject_activity where userid=" . $_SESSION['home_user'] . " and categories.activitytypeid=user_reject_activity.activitytypeid)";
$result = mysql_query($query);

if(mysql_num_rows($result) > 0) {

	echo "<div style='background-color:#F2F2F2'><table><tr><td><p><center><h3>Activities You Don't Want To Do</h3><table>";

	
	if($result){
		$count = 4;
		while($row = mysql_fetch_array($result)){
		
			if($row['type'] != 'adult' || $_SESSION['gender'] == 1) {
				if($count >= 4) {
					echo "<tr>";
					$count = 0;
				}
			
				$count = $count + 1;
				echo "<td  width=2%><input type='checkbox' name='" . $row['activitytypeid'] . "'><td width=2%><a href='show_activity.php?id=" . $row['activitytypeid']. "'><img src='" . $row['image'] . "' width=70px height=70px></a><td width=12%><b><a href='show_activity.php?id=" . $row['activitytypeid']. "'>" . $row['type'] . "</a></b>";
			}
		}
		
	} else {
		die(mysql_error()); // useful for debug
	}
	
	for($i=$count; $i<=4; $i++) {
		echo "<td>";
	}
	
	echo "<tr><td><tr><td><tr><td>";
	echo "<tr><td></table></div>";
}

echo "<p><input type=\"image\" VALUE=\"Submit\" src='save1.jpg' onmouseover='this.src=\"save2.jpg\"' onmouseout='this.src=\"save1.jpg\"'>";

	echo "</table></form>";


?>



</div></table></table></table>

<?php

$db->disconnect(); // disconnect after use is a good habit

?>