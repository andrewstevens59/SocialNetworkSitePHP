<div id='new_page'>

<?php


session_start();


include('connectMySQL.php'); 

$userid = $_SESSION['home_user'];

include('banner.php');
drawBanner(false, $userid);

$query = "select firstname, surname from user where userid=$userid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$username = $row['firstname'] . " " . $row['surname'];


$query = "select thumb, firstname, surname, user.userid, count(*) from user, invites, meetups where invites.meetupid=meetups.meetupid and invites.userid=user.userid and accept!=0 and date_recorded > DATE_SUB(NOW(), INTERVAL 30 DAY) group by userid order by 5 desc limit $num";
$result = mysql_query($query);

if($result){

	echo "<div class='layout' ><b><font size=6>Your Campus Leaders </b></font><br><font size=4><b>(Helps you find other people who are fun to be around, outgoing and sociable)<br><font size=3> Number of invites accepted over the last month</font></b></font></div><p><div class='layout'>";
	
	echo "<center><table><tr>";
	echo "<form ACTION=\"search.php?type=1&user=$userid\" METHOD=POST autocomplete=\"off\">";
	
	?>
	<td valign=middle><input type="text" style="height: 35px;font-size:20px;" name="search" size="80" onkeyup="showSearchRes('friends_page', this.value, 7, 10);"></td>
	<td valign=middle><input type="image" VALUE="Search" src='search1.jpg' onmouseover='this.src="search2.jpg"' onmouseout='this.src="search1.jpg"'></td>

	</form></table></center></div><p><div class='layout' id='friends_page'>
	


<?php

	echo "<table>";
	
	if(mysql_num_rows($result) == 0) {
		echo "<center>You need to persuade your friends to join to start the fun</center>";
	}
	
	while($row = mysql_fetch_array($result)) {
	    echo "<tr><td width=100% $hover onclick=\"window.location = 'user_page.php?user=" . $row ['userid'] . "'\"><table><tr>";
		echo "<td><a href='user_page.php?user=" . $row ['userid'] . "'><img src='" . $row ['thumb'] . "' height=70px width=70px></a>";
		echo "<td><a href='user_page.php?user=" . $row ['userid'] . "'><b>" .$row ['firstname'] . " " . $row ['surname'] ."</b></a>";
		echo "<br><font color='blue'><b>" . $row[4] . " invites accepted</b></font>";
		

		echo "</table><td>";

	}
	
	echo "</table></div></table>";

} else {
	die(mysql_error()); // useful for debug
}


$db->disconnect(); 


?>

</div>