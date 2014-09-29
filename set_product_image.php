<?php

include('connectMySQL.php'); 
  
  session_start();

$query = "update product, photos set product.image=photos.image, product.thumb=photos.thumb where photos.imageid=" . $_REQUEST['photo'] . " and productid=" . $_REQUEST['id'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}


$db->disconnect(); 


header('Location: ' . $_SERVER['HTTP_REFERER']);

	

?> 