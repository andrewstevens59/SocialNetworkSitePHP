<?php

include('connectMySQL.php'); 
include('partial_match.php'); 
  
  session_start();

$userid = $_SESSION['home_user'];
$product = mysql_escape_string($_REQUEST['product']);
$keywords = mysql_escape_string($_REQUEST['keywords']);
$price = mysql_escape_string($_REQUEST['price']);
$description = mysql_escape_string($_REQUEST['description']);

if(strlen($product) == 0) {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	return;
}

if(strlen($price) == 0) {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	return;
}

include('image.php'); 
include('add_to_album.php');
list($dir_thumb, $dir_big) = uploadImage();

$query = "insert into product values ('', '$product', '$keywords', '$dir_big', '$dir_thumb', '$price', 0, '$description', $userid, now())";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

addPartialMatch($product, 8, $row[0]);
addPartialMatch($keywords, 8, $row[0]);

if($dir_thumb != "") {

	$photoid = addPhotoToAlbum($dir_thumb, $dir_big, "For Sale");
	$query = "select max(productid) from product";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);


	$query = "insert into product_images values (" . $row[0] . ",$photoid)";
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error()); 
	}
}

$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

	

?> 