<div id='new_page'>

<?php


session_start();


include('connectMySQL.php'); 

$userid = $_SESSION['home_user'];
if(isset($_REQUEST['user'])) {
	$userid = $_REQUEST['user'];
}

if($userid == $_SESSION['home_user']) {
	$query = "select thumb, firstname, surname, userid from user where userid in (select userid1 from friend_request where userid2=$userid)";
	$result = mysql_query($query);
	$tmp_string = "";

	if($result){

		if(mysql_num_rows($result) > 0) {
		
			$tmp_string .= "<table width=92%><tr><td><div class='rounded-corners' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Friend Requests(" . mysql_num_rows($result) . ") </b></font></div><p>";
			$query = "update alerts set friends=0 where userid=$userid";
			$temp = mysql_query($query);
			
			$tmp_string .= "<div class='rounded-corners' style='border: 2px solid red'>";
		}
		
		include('banner.php');
		drawBanner(false, $userid);

		while($row = mysql_fetch_array($result)){
			$tmp_string .= "<table><tr><td width=100%>";
			$tmp_string .= "<div $hover onclick=\"window.location = 'user_page.php?user=" . $row ['userid'] . "'\"><table><tr>";
			$tmp_string .= "<td><img src='" . $row ['thumb'] . "' height=70px width=70px>";
			$tmp_string .= "<td><b>" .$row ['firstname'] . " " . $row ['surname'] ."</b><br>";
			$tmp_string .= "</table></div>";
			
			$tmp_string .= "<td><a href='accept_friend_request.php?user=" . $row ['userid'] ."'><img src='accept1.jpg' onmouseover=\"this.src='accept2.jpg';\" onmouseout=\"this.src='accept1.jpg';\"></a>";
			$tmp_string .= "<td><a href='reject_friend_request.php?user=" . $row ['userid'] ."'><img src='reject1.jpg' onmouseover=\"this.src='reject2.jpg';\" onmouseout=\"this.src='reject1.jpg';\"></a></table>";
		}
		
		if(mysql_num_rows($result) > 0) {
			$tmp_string .= "</div></table><p>";
		}

	} else {
		die(mysql_error()); // useful for debug
	}

	echo $tmp_string;
} else {

	include('banner.php');
	drawBanner(false, $userid);

	include('check_privacy.php');
	checkAccessRights($userid, "friends");
}

$query = "select firstname, surname from user where userid=$userid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$username = $row['firstname'] . " " . $row['surname'];


$query = "select thumb, firstname, surname, userid, comfortability from user, friends where friends.userid1=$userid and friends.userid2=user.userid order by firstname, surname limit $num";
$result = mysql_query($query);

if($result){

	echo "<div class='layout' ><b><font size=6>$username <img src='arrow.jpg' width=20px height=20px> Friends (" . mysql_num_rows($result) . ") </b></font></div><p>";
	
	echo "<div class='layout'>";
	
	echo "<center><table><tr>";
	echo "<form ACTION=\"search.php?type=1&user=$userid\" METHOD=POST autocomplete=\"off\">";
	
	?>
	<td valign=middle><input type="text" style="height: 35px;font-size:20px;" name="search" size="80" onkeyup="showSearchRes('friends_page', this.value, 1, 10);"></td>
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
		
		if($userid == $_SESSION['home_user']) {
			echo "<br><font size=2><b>";
			
			if($row['comfortability'] == 0) {
				echo "Acquaintances";
			} else if($row['comfortability'] == 1) {
				echo "Talk Ocassionaly";
			} else if($row['comfortability'] == 2) {
				echo "Friends";
			} else if($row['comfortability'] == 3) {
				echo "Would Like To Know Better";
			} else if($row['comfortability'] == 4) {
				echo "Good Friends";
			} else {
				echo "Best Friends";
			}
			
			echo "</b></font>";
		}
		
		echo "</table><td>";
		
		if($userid == $_SESSION['home_user']) {
			echo "<a href='new_message.php?user=" . $row['userid'] . "'><img src='new_message1.jpg' onmouseover='this.src=\"new_message2.jpg\"' onmouseout='this.src=\"new_message1.jpg\"'></a>";
			echo "&nbsp;&nbsp;<a href='edit_friend.php?user=" . $row['userid'] . "'><img src='edit1.jpg' onmouseover='this.src=\"edit2.jpg\"' onmouseout='this.src=\"edit1.jpg\"'></a>";
		}
	}
	
	echo "</table></div>";

} else {
	die(mysql_error()); // useful for debug
}


$db->disconnect(); 


?>

</div>