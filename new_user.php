<?php

session_start();


$firstname = mysql_real_escape_string($_REQUEST['firstname']);
$surname = mysql_real_escape_string($_REQUEST['surname']);
$gender = mysql_real_escape_string($_REQUEST['sex']);
$email = mysql_real_escape_string($_REQUEST['email']);
$password1 = mysql_real_escape_string($_REQUEST['password']);
$password2 = mysql_real_escape_string($_REQUEST['password1']);

$day = mysql_real_escape_string($_REQUEST['day']);
$month = mysql_real_escape_string($_REQUEST['month']);
$year = mysql_real_escape_string($_REQUEST['year']);

$email = strtolower($email);
$firstname = strtolower($firstname);
$surname = strtolower($surname);

$firstname[0] = strtoupper($firstname[0]);
$surname[0] = strtoupper($surname[0]);

include('connectMySQL.php'); 


if(strlen($firstname) == 0) {
	$_SESSION['signup_error'] = "Must give a first name";
	header("Location: home.php");
	return;
}

$_SESSION['firstname'] = $firstname;

if(strlen($surname) == 0) {
	$_SESSION['signup_error'] = "Must give a surname";
	header("Location: home.php");
	return;
}

$_SESSION['surname'] = $surname;

if(strlen($email) == 0) {
	$_SESSION['signup_error'] = "Must give am email address";
	header("Location: home.php");
	return;
}

$_SESSION['email'] = $email;

/*
$to = "callum.mcdonald@uqconnect.edu.au";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "callum.mcdonald@uqconnect.edu.au";
$headers = "From:" . $from;
 if (mail($to,$subject,$message,$headers) == false) {
    $_SESSION['signup_error'] = "Please provide a valid UQ email address " . $email;
	die("Location: home.php");
	return;
} 

if(strpos($email,"@uq") == false) {
	$_SESSION['signup_error'] = "Sorry, must be a UQ email address";
	header("Location: home.php");
	return;
}*/

$query = "select * from user where Email = '" .$email ."'";
$result = mysql_query($query);

if($result){
	if(mysql_num_rows($result) > 0) {
		$_SESSION['signup_error'] = "Email Already Exists";
		header("Location: home.php");
		return;
	}
} else {
	die(mysql_error()); // useful for debug
}

/*
if(strlen($password1) < 6) {
	$_SESSION['signup_error'] = "Passwords must be at least 6 characters long";
	header("Location: home.php");
	return;
}*/

if($password2 != $password1) {
	$_SESSION['signup_error'] = "Passwords do not match";
	header("Location: home.php");
	return;
}

$_SESSION['password'] = $password1;

if($gender == 2) {
	$_SESSION['signup_error'] = "Must specify a gender";
	header("Location: home.php");
	return;
}

$_SESSION['gender'] = $gender;

if($day == 'x') {
	$_SESSION['signup_error'] = "Must fully specify date of birth";
	header("Location: home.php");
	return;
}

$_SESSION['dob_day'] = $day;

if($month == 'x') {
	$_SESSION['signup_error'] = "Must fully specify date of brith";
	header("Location: home.php");
	return;
}

$_SESSION['dob_month'] = $month;

if($year == 'x') {
	$_SESSION['signup_error'] = "Must fully specify date of brith";
	header("Location: home.php");
	return;
}

$_SESSION['dob_year'] = $year;

$mysqldate = date( 'Y-m-d H:i:s', mktime(0, 0, 0, $month, $day, $year));
$phpdate = strtotime( $mysqldate );

$query = "insert into User VALUES('" .$firstname ."','" .$surname ."','" .$email ."','" .$password1 ."',FROM_UNIXTIME($phpdate), 0, 0, '', '', '', '', '', '', '', '', '', '', $gender, '', 0, 0, 0, -1, '', now())";
$result = mysql_query($query);

if($result){
	
	$query = "select userid from user where email = '" . $email . "'";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$row = mysql_fetch_array($result);
	
	$_SESSION['home_user'] = $row['userid'];
	$_SESSION['email'] = $email;
	
	$query = "insert into privacy VALUES(" . $row['userid'] . ", 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1)";
	$result = mysql_query($query);
	
	echo $query;
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "insert into alerts VALUES(" . $row['userid'] . ", 0, 0, 0, 0, 0)";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	$query = "insert into user_reject_activity VALUES(" . $row['userid'] . ", 0)";
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	include('partial_match.php'); 
	addPartialMatch($firstname, $db, 0);
	addPartialMatch($surname, $db, 0);
}
else{
	die(mysql_error()); // useful for debug
}

$db->disconnect(); // disconnect after use is a good habit

header("Location: profile.php");

?>
