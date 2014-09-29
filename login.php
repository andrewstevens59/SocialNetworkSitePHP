<?php


session_start();

include('connectMySQL.php'); 

$email = mysql_real_escape_string($_REQUEST['email']);
$password = mysql_real_escape_string($_REQUEST['password']);

$_SESSION['email1'] = $email;
$_SESSION['password1'] = $password;

if(strlen($password) == 0) {
	$_SESSION['error'] = "Must give a password";
	header("Location: home.php");
	return;
}

require_once('class_people.php');
$people = new People;
 
$ip = $_SERVER['REMOTE_ADDR'];
if (!$people->exists($ip, $db)) {
	$people->insert($ip, $db);
}
else {
	$people->update($ip, $db);
}
 
$people->truncate($db);

	
$query = "select gender, thumb, image, firstname, surname, userid, last_login from user where Email = '" .$email ."' and password='" . $password ."'";

$result = mysql_query($query);
$tmp_string = "";

if($result){

	$count = 0;
	if($row = mysql_fetch_array($result)){
		$_SESSION['home_user'] = $row['userid'];
		$_SESSION['user_name'] = $row['firstname'] . " " . $row['surname'];
		$_SESSION['micro_image'] = $row['thumb'];
		$_SESSION['gender'] = $row['gender'];
		$_SESSION['last_login'] = $row['last_login'];
		$_SESSION['current_login'] = date("Y-m-d h:i:s");
		$count = 1;
	}

	if($count == 0) {
		$_SESSION['error'] = "Incorrect login";
		header("Location: home.php");
		return;
	}
} else {

	die(mysql_error()); 
}

$query = "select UNIX_TIMESTAMP(last_meetup) from user where userid=" . $_SESSION['home_user'];
$result1 = mysql_query($query);
$row = $row = mysql_fetch_array($result1);

$prev_date = date("Y-m-d", $row[0]);
$datetime1 = new DateTime($prev_date);
$datetime2 = new DateTime();
$interval = $datetime1->diff($datetime2);
$interval = intval($interval->format('%R%a'));

if( $interval > 2) {
	// automatically generate an invite if activity is low
	include('generate_invite.php');
}

$query = "update user set last_login=now() where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from friend_request WHERE timestamp < DATE_SUB(NOW(), INTERVAL 60 DAY) and userid1=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from arranged_date WHERE timestamp < DATE_SUB(NOW(), INTERVAL 6 MONTH) and userid1=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from alert_updates WHERE timestamp < DATE_SUB(NOW(), INTERVAL 15 DAY) and userid1=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from invites WHERE meetupid in (select meetupid from meetups where date_recorded < DATE_SUB(NOW(), INTERVAL 60 DAY)) and userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from invite_message WHERE meetupid in (select meetupid from meetups where date_recorded < DATE_SUB(NOW(), INTERVAL 15 DAY)) and userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from invites WHERE meetupid in (select meetupid from meetups where date_recorded < DATE_SUB(NOW(), INTERVAL 0 DAY)) and accept!=1 and userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from meetups WHERE date_recorded < DATE_SUB(NOW(), INTERVAL 70 DAY)";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from invite_updates WHERE timestamp < DATE_SUB(NOW(), INTERVAL 10 DAY) and userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from last_n_activities WHERE timestamp < DATE_SUB(NOW(), INTERVAL 180 DAY) and userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from like_person WHERE timestamp < DATE_SUB(NOW(), INTERVAL 30 DAY) and userid1=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from indv_meetup WHERE timestamp < DATE_SUB(NOW(), INTERVAL 60 DAY) and userid1=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from friend_request WHERE timestamp < DATE_SUB(NOW(), INTERVAL 6 MONTH) and userid1=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

header("Location: news.php");

?>