<?php


session_start();

include('connectMySQL.php'); 


include('banner.php');
drawBanner(false, $_SESSION['home_user']);

echo "<div class='rounded-corners'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Group Meetups </b></font></div><p>";

echo "<div class='rounded-corners'><center><img src='group_meetup.jpg'></center><p><div style='background-color:#F2F2F2'><font size=5>";
echo "<p>Group meetups is an arranged meeting between approximately 8 individuals who have been chosen at random. <br><p>There is an approximately <b>even division of gender</b> for the chosen grouup</b>.";
echo "<p>Only individuals <b>who have requested</b> a meetup will be assigned a time and place to meet at <b>St Lucia Campus</b>.";
echo "<p>Group meetups are designed to allow you to meet people you ordinarily wouldn't. ";
echo "<p>After the meetup you have the opportunity to request an individual meetup (see Individual Meetups).";
echo "<p>Individual meetups then allow you to get to know a particular person better.";
echo "<p>Individual meetups are only arranged if <b>both individuals have requested it</b>.";
echo "</font></div></div><p>";

$query = "select UNIX_TIMESTAMP(last_meetup) from user where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);
$row = mysql_fetch_array($result);

$prev_date = date("d", $row[0]);

if( (date("d") - $prev_date) < 2) {
	echo "<div class='rounded-corners'><center>Cannot Request a Meetup for another " . (2 + date("d") - $prev_date) . " days</center></div>";
	echo "</table>";
	$db->disconnect();
	return;
}

$query = "select * from male_date where blind=0 and userid=" . $_SESSION['home_user'] . " union select * from female_date where blind=0 and userid=" . $_SESSION['home_user'];
$result = mysql_query($query);


if($result){


	if(mysql_num_rows($result) > 0) {
		echo "<div class='rounded-corners'><center><img src='req_group_meetup2.jpg'></center>";
		echo "<center>(You will be envited to attend a group metup when enough members have requested it)</center>";
		
		echo "</div>";
	} else {
	
		echo "<div class='rounded-corners'><center><a href='request_group_meetup.php'><img src='req_group_meetup1.jpg' onmouseover='this.src=\"req_group_meetup3.jpg\"' onmouseout='this.src=\"req_group_meetup1.jpg\"'></a></center></div>";
	}

} else {
	die(mysql_error()); // useful for debug
}

echo "</table>";


$db->disconnect(); // disconnect after use is a good habit


?>