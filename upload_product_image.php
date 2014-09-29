<?php

include('connectMySQL.php'); 
  
  session_start();

include('image.php'); 
include('add_to_album.php');
list($dir_thumb, $dir_big) = uploadImage();

if($dir_thumb != "") {

	$photoid = addPhotoToAlbum($dir_thumb, $dir_big, "For Sale");
	$query = "insert into product_images values (" . $_REQUEST['id'] . ",$photoid)";
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error()); 
	}
}

$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

	

?> 