<?php


session_start();

include('connectMySQL.php'); 


include('banner.php');
drawBanner(false, $_SESSION['home_user']);

echo "<table width=90%><tr><td><div class='layout'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Meetup Pool </b></font></div><p>";

echo "<div class='layout'><div style='background-color:white'><center><img src='meetup_pool.jpg'></center></div><div style='background-color:#F2F2F2'><font size=3>";
echo "By joining the meetup pool you can browse other members who would also like to meet up with you.";
echo "<p>If you would like to meetup with someone in the pool send them a meetup request.";
echo "<p>If they nominate to meetup with you aswell, then a time and place on the <b>St Lucia Campus</b> will be arranged for both of you to meet";
echo "<P>You also have the option to leave the pool at any time.";
echo "<P>You can also send the person a <b>like</b>, which they will be notified of when you send it.";
echo "</font></div></div><p>";

$query = "select all_qs_ans from user where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);
$row = mysql_fetch_array($result);

if($row[0] == 0) {
	echo "<div class='layout'><font color='red'><center>You must answer all questions in your <a href='edit_details.php'>personality profile</a>, before you're allowed to partake in this activity</center></font></div>";
	$db->disconnect(); // disconnect after use is a good habit
	return;
}

$query = "select * from meetup_pool where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);


if($result){


	if(mysql_num_rows($result) > 0) {
		echo "<div class='layout'><center><a href='leave_meetup_pool.php'><img src='leave_pool1.jpg' onmouseover='this.src=\"leave_pool2.jpg\"' onmouseout='this.src=\"leave_pool1.jpg\"'></a>";
		echo "&nbsp;&nbsp;<a href='search_pool.php'><img src='browse1.jpg' onmouseover='this.src=\"browse2.jpg\"' onmouseout='this.src=\"browse1.jpg\"'></a>";
		echo "</center></div>";
	} else {
	
		echo "<div class='layout'><center><a href='join_meetup_pool.php'><img src='join_pool1.jpg' onmouseover='this.src=\"join_pool2.jpg\"' onmouseout='this.src=\"join_pool1.jpg\"'></a></center></div>";
	}

} else {
	die(mysql_error()); // useful for debug
}

echo "</table></table>";


$db->disconnect(); // disconnect after use is a good habit


?>