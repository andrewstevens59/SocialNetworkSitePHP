<?php

  
  session_start();

$description = mysql_real_escape_string($_REQUEST['description']);
$interestedin = mysql_real_escape_string($_REQUEST['interestedin']);
$status = mysql_real_escape_string($_REQUEST['status']);
$degree = mysql_real_escape_string($_REQUEST['degree']);
$courses = mysql_real_escape_string($_REQUEST['courses']);
$gender = mysql_real_escape_string($_REQUEST['gender']);
$employers = mysql_real_escape_string($_REQUEST['employers']);
$highschool = mysql_real_escape_string($_REQUEST['highschool']);
$university = mysql_real_escape_string($_REQUEST['university']);
$ethnicity = mysql_real_escape_string($_REQUEST['ethnicity']);

$day = mysql_real_escape_string($_REQUEST['day']);
$month = mysql_real_escape_string($_REQUEST['month']);
$year = mysql_real_escape_string($_REQUEST['year']);

$courses_priv = mysql_real_escape_string($_REQUEST['courses_priv']);
$dob_priv = mysql_real_escape_string($_REQUEST['dob_priv']);
$description_priv = mysql_real_escape_string($_REQUEST['description_priv']);
$degree_priv = mysql_real_escape_string($_REQUEST['degree_priv']);
$ethnicity_priv = mysql_real_escape_string($_REQUEST['ethnicity_priv']);
$highschool_priv = mysql_real_escape_string($_REQUEST['highschool_priv']);
$university_priv = mysql_real_escape_string($_REQUEST['university_priv']);
$employers_priv = mysql_real_escape_string($_REQUEST['employers_priv']);

$_SESSION['gender'] = $gender;

$string = "";
$all_ans = 1;

for($i=0; $i<55; $i++) {
	if(isset($_REQUEST['q' . $i])) {
		$string .= $_REQUEST['q' . $i];
		
		if($_REQUEST['q' . $i] == '1') {
			$tok = strtok($q[$i], " {},");

			while ($tok != false) {
				$freq[$tok] += 1.0 / $num[$tok];
				$tok = strtok(" {},");
			}
		}
		
	} else {
		$string .= "x";
		$all_ans = 0;
	}
}

include('partial_match.php'); 

include('connectMySQL.php'); 

$query = "update privacy set courses=$courses_priv, dob=$dob_priv, description=$description_priv, degree=$degree_priv, ethnicity=$ethnicity_priv, highschool=$highschool_priv, university=$university_priv, employers=$employers_priv where userid = " . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "delete from permute_set WHERE permute_set.userid=" .$_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

addPartialMatch($courses, $db, 1);
addPartialMatch($degree, $db, 2);
addPartialMatch($_SESSION['user_name'], $db, 0);

$query = "UPDATE User SET";

$mysqldate = date( 'Y-m-d H:i:s', mktime(0, 0, 0, $month, $day, $year));
$phpdate = strtotime( $mysqldate );

$query .= " DOB= FROM_UNIXTIME($phpdate), ethnicity=" .$ethnicity. ", questions='" .$string. "', all_qs_ans='" .$all_ans . "', description='" .$description ."', interestedin=" .$interestedin . ",gender=" . $gender .",status=" . $status .",degree='"  . $degree ."',courses='"  . $courses . "',university='"  . $university . "',employers='"  . $employers . "',highschool='"  . $highschool .  "'";
if($status == 0) {
	$query .= ", relid=-1";
}

$query .= " WHERE userid=\"" .$_SESSION['home_user'] ."\"";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$query = "delete from courses where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}
	
$tok = strtok($courses, " ,-");

while ($tok != false) {

	$tok = strtolower($tok);

	$query = "insert into courses values (" . $_SESSION['home_user'] . ", '$tok', 0)";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	$tok = strtok(" ,-");
}

$db->disconnect(); // disconnect after use is a good habit

header("Location: user_page.php");
	

?> 