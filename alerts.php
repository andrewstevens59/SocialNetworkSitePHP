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

</style>

<?php


session_start();

include('connectMySQL.php'); 

$query = "update alerts set alerts.alerts=0 where userid=" .$_SESSION['home_user'];
$temp = mysql_query($query);

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$query = "select wallid, userid, message, thumb, firstname, surname from alert_updates, user where alert_updates.userid1=user.userid and alert_updates.timestamp > '" . $_SESSION['last_login'] . "' and alert_updates.userid2=" . $_SESSION['home_user'] . " order by timestamp desc";
$result = mysql_query($query);

if(mysql_num_rows($result) > 0) {
	echo "<div class='layout' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> New Alerts</b></font></div><p><div class='layout' style='border:2px solid red'>";

	if($result){

		while($row = mysql_fetch_array($result)){
		
			if($row ['wallid'] >= 0) {
				// comment or like
				echo "<div $hover onclick=\"window.location = 'show_alert.php?user=" . $row ['wallid'] . "'\"><table><tr>";
			} else {
				// friend accept 
				echo "<div $hover onclick=\"window.location = 'user_page.php?user=" . $row ['userid'] . "'\"><table><tr>";
			}
			
			echo "<td><a href='user_page.php?user=" . $row['userid'] . "'><img src='" . $row ['thumb'] . "' width=70px height=70px></a>";
			echo "<td><b><a href='user_page.php?user=" . $row['userid'] . "'>" .$row ['firstname'] . " " . $row ['surname'] ."</a></b>&nbsp;&nbsp;" . $row ['message'] . "<br>";
			echo "</table></div>";
		}
		
		echo "</div><p>";

	} else {
		die(mysql_error()); // useful for debug
	}
}

$query = "select userid, message, thumb, firstname, surname, wallid from alert_updates, user where alert_updates.userid1=user.userid and alert_updates.timestamp <= '" . $_SESSION['last_login'] . "' and alert_updates.userid2=" . $_SESSION['home_user'] . " order by timestamp desc limit 5";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

echo "<div class='layout' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Old Alerts (" . mysql_num_rows($result) . ")</b></font></div><p>";

if(mysql_num_rows($result) > 0) {
	echo "<div class='layout'>";

	while($row = mysql_fetch_array($result)){
		if($row ['wallid'] >= 0) {
			// comment or like
			echo "<div $hover onclick=\"window.location = 'show_alert.php?user=" . $row ['wallid'] . "'\"><table><tr>";
		} else {
			// friend accept 
			echo "<div $hover onclick=\"window.location = 'user_page.php?user=" . $row ['userid'] . "'\"><table><tr>";
		}
		
		echo "<td><a href='user_page.php?user=" . $row['userid'] . "'><img src='" . $row ['thumb'] . "' width=70px height=70px></a>";
		echo "<td><b><a href='user_page.php?user=" . $row['userid'] . "'>" .$row ['firstname'] . " " . $row ['surname'] ."</a></b>&nbsp;&nbsp;" . $row ['message'] . "<br>";
		echo "</table></div>";
	}
	
	echo "</div>";
}

echo "</table>";

$query = "update alert_updates set alert_updates.new=0 where alert_updates.userid2=" .$_SESSION['home_user'];
$temp = mysql_query($query);

$db->disconnect(); // disconnect after use is a good habit


?>