<?php

  session_start();

$description = mysql_real_escape_string($_REQUEST['description']);
$interestedin = mysql_real_escape_string($_REQUEST['interestedin']);
$status = mysql_real_escape_string($_REQUEST['status']);
$degree = mysql_real_escape_string($_REQUEST['degree']);
$courses = mysql_real_escape_string($_REQUEST['courses']);
$employers = mysql_real_escape_string($_REQUEST['employers']);
$highschool = mysql_real_escape_string($_REQUEST['highschool']);
$university = mysql_real_escape_string($_REQUEST['university']);
$ethnicity = mysql_real_escape_string($_REQUEST['ethnicity']);
$postcode = mysql_real_escape_string($_REQUEST['postcode']);
$entrepreneur = 0;


if(isset($_REQUEST['entrepreneur']) == true) {
	$entrepreneur = 1;
}

$string = "";
$all_ans = 1;

for($i=0; $i<55; $i++) {
	if(isset($_REQUEST['q' . $i])) {
		$string .= $_REQUEST['q' . $i];
		
	} else {
		$string .= "x";
		$all_ans = 0;
	}
}
include('connectMySQL.php'); 

include('image.php'); 
include('partial_match.php'); 

list($dir_thumb, $dir_big) = uploadImage();

$temp_image = false;

if($dir_big == "") {
	$temp_image = true;
	if($_SESSION['gender'] == 1) {
		$dir_big = "no_photo_male.jpg";
		$dir_thumb = "no_photo_male.jpg";
	} else {
		$dir_big = "no_photo_female.jpg";
		$dir_thumb = "no_photo_female.jpg";
	}

} 
$_SESSION['user_name'] = $_SESSION['firstname'] . " " . $_SESSION['surname'];
$_SESSION['micro_image'] = $dir_thumb;

$query = "update privacy set courses=2, dob=2, description=2, degree=2, ethnicity=0, highschool=2, university=2, employers=2 where userid = " . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

addPartialMatch($courses, $db, 1);
addPartialMatch($degree, $db, 2);

$query = "UPDATE User SET";

$query .= " image='$dir_big', thumb='$dir_thumb', postcode='$postcode', entrepreneur=$entrepreneur, ethnicity=" .$ethnicity. ", questions='" .$string. "', all_qs_ans='" .$all_ans . "', description='" .$description ."', interestedin=" .$interestedin .",status=" . $status .",degree='"  . $degree ."',courses='"  . $courses . "',university='"  . $university . "',employers='"  . $employers . "',highschool='"  . $highschool . "' WHERE userid=\"" .$_SESSION['home_user'] ."\"";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}
	
$tok = strtok($courses, " ,-");

while ($tok != false) {

	$tok = strtolower($tok);
	$query = "delete from courses where course='$tok'";
	$result = mysql_query($query);

	$query = "insert into courses values (" . $_SESSION['home_user'] . ", '$tok', 0)";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	$tok = strtok(" ,-");
}


$query = "select albumid from album where name='Profile Photos' and userid = '" . $_SESSION['home_user'] . "'";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$row = mysql_fetch_array($result);

$query = "insert into photos values (" . $_SESSION['home_user'] . ", '$dir_big', '$dir_thumb', '', now(), " . $row[0] . ")";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}


$db->disconnect(); // disconnect after use is a good habit

header("Location: user_page.php");
	

?> 