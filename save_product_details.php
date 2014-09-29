<?php

include('connectMySQL.php'); 
include('partial_match.php'); 
  
  session_start();

$userid = $_SESSION['home_user'];
$product = mysql_escape_string($_REQUEST['product']);
$keywords = mysql_escape_string($_REQUEST['keywords']);
$price = mysql_escape_string($_REQUEST['price']);
$description = mysql_escape_string($_REQUEST['description']);

include('image.php'); 
include('add_to_album.php');
list($dir_thumb, $dir_big) = uploadImage();

$query = "update product set name='$product', keywords='$keywords', price='$price', description='$description' where productid=" . $_REQUEST['id'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

$query = "delete from permute_set WHERE permute_set.type=8 and permute_set.userid=" .$_REQUEST['id'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

addPartialMatch($product, 8, $_REQUEST['id']);
addPartialMatch($keywords, 8, $_REQUEST['id']);


if($dir_thumb != "") {

	$photoid = addPhotoToAlbum($dir_big, $dir_thumb, "For Sale");
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