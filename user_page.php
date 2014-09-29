<?php


session_start();


include('connectMySQL.php'); 

$userid = $_SESSION['home_user'];
if(isset($_REQUEST['user'])) {
	$userid = $_REQUEST['user'];
}

include('banner.php');
drawBanner(false, $userid);

$query = "select information, courses, dob, description, degree, ethnicity, highschool, university, employers, in_rel from privacy where userid=$userid";
$result = mysql_query($query);
$privacy = mysql_fetch_array($result);

$friend_status = 1;
$query = "select * from friends where userid1=$userid and userid2=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

if(mysql_num_rows($result) == 0) {
	$friend_status = 2;
}

if($privacy['information'] == 0) {
	$is_friend = 2;
}

if($userid == $_SESSION['home_user']) {
	$friend_status = 0;
}


$query = "select UNIX_TIMESTAMP(dob), ethnicity, university, highschool, employers, thumb, gender, image, firstname, surname, description, degree, status, interestedin, courses, userid, relid from user where userid=$userid";

$result = mysql_query($query);
$tmp_string = "";

if($result){

	if($row = mysql_fetch_array($result)){
		echo "<div class='layout' ><b><font size=6>" . $row['firstname'] . " " . $row['surname'] . " <img src='arrow.jpg' width=20px height=20px> Information </b></font></div><p>";
		
		include('check_privacy.php');
		checkAccessRights($userid, "information");
		
		if($privacy['in_rel'] >= $friend_status && $row['status'] > 0) {
			echo "<div class='layout'><table><tr>";
			
			$query = "select thumb, firstname, surname from user where userid=" . $row['relid'];
			$tmp = mysql_query($query);
			$rel_person = mysql_fetch_array($tmp);
			
			echo "<td><a href='user_page.php?user=" . $row['relid'] . "'><img src='" . $rel_person['thumb'] . "' width=70px height=70px></a><td><a href='user_page.php?user=" . $row['relid'] . "'><b>" . $rel_person['firstname'] . " " . $rel_person['surname'] . "</b></a> ";
			
			if($row['status'] == 1) {
				echo "is in a relationship with";
			} else if($row['status'] == 2) {
				echo "is engaged to";
			} else if($row['status'] == 3) {
				echo "is married to";
			} else {
				echo "is in an open relationship with";
			}
			
			echo " <b> " . $_SESSION['user_name'] . "</b>";
			
			echo "</table></div><p>";
		}

		echo "<div class='layout'>";
		echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Gender</b></font></div><p>";
		
		if($row['gender'] == 1) {
			echo "male";
		} else {
			echo "female";
		}
		
		if(strlen($row['description']) > 0 && $privacy['description'] >= $friend_status) {
			echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Description</b></font></div><p>";
			echo "" . $row['description'];
		}
		
		if(strlen($row['ethnicity']) > 0 && $privacy['ethnicity'] >= $friend_status) {
			echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Ethnicity</b></font></div><p>";
			if($row['ethnicity'] == 0) {
				echo "<option value=0>White (Caucaisian)";
			} else if($row['ethnicity'] == 1) { 
				echo "<option value=1>Hispanic";
			} else if($row['ethnicity'] == 2) {
				echo "<option value=2>Indigeneous Native";
			} else if($row['ethnicity'] == 3) {
				echo "<option value=3>African American";
			} else if($row['ethnicity'] == 4) {
				echo "<option value=4>Mediterranean";
			} else if($row['ethnicity'] == 5) {
				echo "<option value=5>West Indian ";
			} else if($row['ethnicity'] == 6) {
				echo "<option value=6>Maori";
			} else if($row['ethnicity'] == 7) {
				echo "<option value=7>African";
			} else if($row['ethnicity'] == 8) {
				echo "<option value=8>Asian";
			} else if($row['ethnicity'] == 9) {
				echo "<option value=9>Indian";
			} else if($row['ethnicity'] == 10) {
				echo "<option value=10>Latino";
			} else if($row['ethnicity'] == 11) {
				echo "<option value=11>Middle Eastern";
			} else {
				echo "<option value=12>Other";
			}
		}
		
		if(strlen($row['university']) > 0 && $privacy['university'] >= $friend_status) {
			echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>University</b></font></div><p>";
			echo "" . $row['university'];
		}

		if(strlen($row['highschool']) > 0 && $privacy['highschool'] >= $friend_status) {
			echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Highschool</b></font></div><p>";
			echo "" . $row['highschool'];
		}
		
		if(strlen($row['employers']) > 0 && $privacy['employers'] >= $friend_status) {
			echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Employers</b></font></div><p>";
			echo "" . $row['employers'];
		}
		
		if(strlen($row[0]) > 0 && $privacy['dob'] >= $friend_status) {
			echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Age</b></font></div><p>";
			
			$prev_date = date("Y-m-d", $row[0]);
			$datetime1 = new DateTime($prev_date);
			$datetime2 = new DateTime();
			$interval = $datetime1->diff($datetime2);
				
			echo $interval->y;
		}
		
		if(strlen($row['degree']) > 0 && $privacy['degree'] >= $friend_status) {
			echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Degree</b></font></div><p>";
			echo "" . $row['degree'];
		}
		
		echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Relationship Status</b></font></div><p>";
		
		if($row['status'] == 0) {
			echo "Single";
		} else if($row['status'] == 1) {
			echo "In a relationship";
		} else if($row['status'] == 2) {
			echo "Engaged";
		} else if($row['status'] == 3) {
			echo "Married";
		} else {
			echo "In an open relationship";
		}
		
		echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Interested In</b></font></div><p>";
		
		if($row['interestedin'] == 0) {
			echo "none";
		} else if($row['interestedin'] == 1) {
			echo "men";
		} else {
			echo "women";
		}
		
		if(strlen($row['courses']) > 0) {
			if($privacy['courses'] >= $friend_status) {
				echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Courses</b></font></div><p>";
				echo "" . $row['courses'];
			}
		} else {
			echo "<div style=\"background-color:#F2F2F2; width:50%;\" ><font size=4><b>Courses</b></font></div><p>";
			echo "You will not be invited to class events, such as mixers, and graduation celebrations,<br> unless you specify the courses you are enrolled in this semester";
		}
		
		echo "</div>";
		
		if($userid == $_SESSION['home_user']) {
			echo "<p><div class='layout'><a href='edit_details.php'><center>Edit Details</center></a></div>";
		}
		
		echo "</table>";
	}

} else {

	die(mysql_error()); 
}

$db->disconnect(); 


?>