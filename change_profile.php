<?php

  
  session_start();

$imageid = mysql_real_escape_string($_REQUEST['id']);
include('connectMySQL.php'); 

$query = "UPDATE user, photos SET user.image=photos.image, user.thumb=photos.thumb where user.userid=" .$_SESSION['home_user'] ." and photos.imageid=$imageid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "select image, thumb from photos where photos.imageid=$imageid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$_SESSION['micro_image'] = $row['thumb'];
$_SESSION['thumb'] = $row['image'];

$db->disconnect(); // disconnect after use is a good habit


header('Location: ' . $_SERVER['HTTP_REFERER']);
	

?> 