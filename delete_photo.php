<?php

  
  session_start();

$imageid = mysql_real_escape_string($_REQUEST['id']);
include('connectMySQL.php'); 

$query = "select image, thumb from photos where photos.imageid=$imageid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

if($row['image'] == 'no_photo_male.jpg') {
	$db->disconnect(); 
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	return;
}

if($row['image'] == 'no_photo_female.jpg') {
	$db->disconnect(); 
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	return;
}

unlink($row['thumb']);
unlink($row['image']);

$query = "select * from photos, user where photos.imageid=$imageid and photos.image=user.image and user.userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

if(mysql_num_rows($result) != 0) {

	if($_SESSION['gender'] == 1) {
		$query = "update user set image='no_photo_male.jpg', thumb='no_photo_male.jpg' where user.userid=" . $_SESSION['home_user'];
		$result = mysql_query($query);
		
		$_SESSION['micro_image'] = 'no_photo_male.jpg';
		$_SESSION['thumb'] = 'no_photo_male.jpg';
	
	} else {
		$query = "update user set image='no_photo_female.jpg', thumb='no_photo_female.jpg' where user.userid=" . $_SESSION['home_user'];
		$result = mysql_query($query);
		
		$_SESSION['micro_image'] = 'no_photo_female.jpg';
		$_SESSION['thumb'] = 'no_photo_female.jpg';
	}

	if($result == false) {
		die(mysql_error()); 
	}
}

$query = "delete from photos where photos.imageid=$imageid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$db->disconnect(); 
header('Location: ' . $_SERVER['HTTP_REFERER']);
	

?> 