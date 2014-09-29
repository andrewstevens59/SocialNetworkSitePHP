<div id='new_page'>

<?php


session_start();

include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

echo "<div class='layout'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px>Browse Meetup Pool </b></font></div><p>";

$query = "select count(*) from like_person where userid2=" . $_SESSION['home_user'];
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$like_count = $row[0];

$query = "select count(*) from indv_meetup where userid1=" . $_SESSION['home_user'];
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$meetup_req_count = $row[0];

$query = "select questions from user where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);
$user_row = mysql_fetch_array($result);

$query = "select UNIX_TIMESTAMP(user.dob), questions, user.firstname, user.surname, user.degree, user.userid, user.image, user.description from meetup_pool, user where meetup_pool.userid=user.userid and ";

if(isset($_REQUEST['m_r']) == true) {
	echo "<div class='layout'><center><table><tr><td><a href='browse_pool.php'>Search</a><td width=20%><td><b>My Meetup Requests [$meetup_req_count]</b><td width=20%><td><a href='browse_pool.php?l_p'>People Who Like Me [$like_count]</a></table></center></div><P>";
	$query = "select UNIX_TIMESTAMP(user.dob), questions, user.firstname, user.surname, user.degree, user.userid, user.image, user.description from user, indv_meetup where user.userid=indv_meetup.userid2 and indv_meetup.userid1=" . $_SESSION['home_user'];
} else if(isset($_REQUEST['l_p']) == true) {
	echo "<div class='layout'><center><table><tr><td><a href='browse_pool.php'>Search</a><td width=20%><td><a href='browse_pool.php?m_r'>My Meetup Requests [$meetup_req_count]</a><td width=20%><td><b>People Who Like Me [$like_count]</b></table></center></div><P>";
	$query = "select UNIX_TIMESTAMP(user.dob), questions, user.firstname, user.surname, user.degree, user.userid, user.image, user.description from user, like_person where user.userid=like_person.userid1 and like_person.userid2=" . $_SESSION['home_user'];
} else {

	echo "<div class='layout'><center><table><tr><td><b>Search</b><td width=20%><td><a href='browse_pool.php?m_r'>My Meetup Requests [$meetup_req_count]</a><td width=20%><td><a href='browse_pool.php?l_p'>People Who Like Me [$like_count]</a></table></center></div><P>";

	if(isset($_REQUEST['seeking'])) {
		$_SESSION['seeking'] = $_REQUEST['seeking'];
		$_SESSION['age_end'] = $_REQUEST['age_end'];
		$_SESSION['age_start'] = $_REQUEST['age_start'];
		$_SESSION['ethnicity'] = $_REQUEST['ethnicity'];
		
		if(isset($_REQUEST['online'])) {
			$_SESSION['online'] = 1;
		} else {
			$_SESSION['online'] = 0;
		}
	}

	if($_SESSION['seeking'] == 0) {
		$query .= "user.gender='1'";
	} else if($_SESSION['seeking'] == 1) {
		$query .= "user.gender='0'";
	} else if($_SESSION['seeking'] == 2) {
		// male or female
	} else if($_SESSION['seeking'] == 3) {
		$query .= "user.gender='1' and user.interestedin=2";
	} else if($_SESSION['seeking'] == 4) {
		$query .= "user.gender='0' and user.interestedin=1";
	} else if($_SESSION['seeking'] == 5) {
		$query .= "user.gender='1' and user.interestedin=1";
	} else if($_SESSION['seeking'] == 6) {
		$query .= "user.gender='0' and user.interestedin=2";
	}

	$query .= " and user.dob >= DATE_SUB(NOW(), INTERVAL " . $_SESSION['age_end'] . " YEAR)";
	$query .= " and user.dob <= DATE_SUB(NOW(), INTERVAL " . $_SESSION['age_start'] . " YEAR)";

	if($_SESSION['ethnicity'] != 13) {
		$query .= " and user.ethnicity=" . $_SESSION['ethnicity'];
	}
	
	if($_SESSION['online'] == 1) {
		$query .= " and user.userid in (select userid from users_online)";
	}
} 

$query .= " order by (";
for($i=0; $i<strlen($user_row[0]); $i++) {
	if($i == 0) {
		$query .= " (SUBSTRING(questions," .  ($i + 1) . ", 1) ^ '" . $user_row[0][$i] . "')";
	} else {
		$query .= " + (SUBSTRING(questions," .  ($i + 1) . ", 1) ^ '" . $user_row[0][$i] . "')";
	}
}


$query .= " ) asc limit $num";

echo "<div class='layout'>";

if(isset($_REQUEST['l_p']) == true) {
	echo "<center><b>People who like you, may want to meet up with you, send them a meetup request if you're interested</b></center><p><hr color='black'>";
}

$result = mysql_query($query);

if($result){

	if(mysql_num_rows($result) == 0) {
		echo "<center><b>Sorry No Matches At The Moment</b></center>";
	}

	while($row = mysql_fetch_array($result)) {
		
		echo "<table style=\"background-color:#E6E6FA\"><tr><td width=100%><table width=100% height=100% style=\"background-color:#E6E6FA\"><tr><td><table style=\"background-color:#E6E6FA;\" width=100%><tr><td width=100%><a href='user_page.php?user=" . $row['userid'] . "'><font size=6>" . $row['firstname'] . " " . $row['surname'];
		
		$prev_date = date("Y-m-d", $row[0]);
		$datetime1 = new DateTime($prev_date);
		$datetime2 = new DateTime();
		$interval = $datetime1->diff($datetime2);
				
		echo "&nbsp;&nbsp; " . $interval->y . "</a></font><font size=4><br><b>" . $row['degree'] . "</b></font>&nbsp;&nbsp;";
		calculateMatch($user_row[0], $row['questions']);

		echo "<td>";
	
		
		$query = "select * from like_person where userid1=" . $_SESSION['home_user'] . " and userid2=" . $row['userid'];
		$tmp = mysql_query($query);
	
		if(mysql_num_rows($tmp) > 0) {
			echo "<td><img src='like2.jpg'>";
		} else {
			echo "<td><a href='' onclick='requestLike($like_count);reloadPage(\"like_person.php\", \"user=" . $row['userid'] . "\", \"browse_pool.php\", \"new_page\");return false;'><img onmouseover='this.src=\"like2.jpg\"' onmouseout='this.src=\"like1.jpg\"' src='like1.jpg'></a>";
		}
		
		$query = "select * from indv_meetup where userid1=" . $_SESSION['home_user'] . " and userid2=" . $row['userid'];
		$tmp = mysql_query($query);
		
		if($result == false) {
			die(mysql_error()); 
		}
	
		if(mysql_num_rows($tmp) > 0) {
			echo "<td width=5%><a href='' onclick='reloadPage(\"remove_indv_meetup.php\", \"user=" . $row['userid'] . "\", \"browse_pool.php\", \"new_page\");return false;'><img src='meeting3.jpg'></a>";
		} else {
			echo "<td width=5%><a href='' onclick='requestMeetup($meetup_req_count);reloadPage(\"req_indv_meetup.php\", \"user=" . $row['userid'] . "\", \"browse_pool.php\", \"new_page\");return false;'><img onmouseover='this.src=\"meeting2.jpg\"' onmouseout='this.src=\"meeting1.jpg\"' src='meeting1.jpg'></a>";
		}
		
		echo "</table>";
		
		echo "<tr><td style=\"background-color:#F2F2F2;\" height='70'>" . $row['description'];
		
		echo "</table><td><center><a href='user_page.php?user=" . $row['userid'] . "'><img src='" . $row['image'] . "' width=110px height=140px></a></center>";
		
		echo "</table>";
	} 


} else {
	die(mysql_error()); // useful for debug
}

echo "</div><p>";
echo "</table>";

		
$db->disconnect(); // disconnect after use is a good habit


?>

</div>