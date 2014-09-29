<?php

session_start();

include('connectMySQL.php'); 

include('add_to_album.php'); 
addToAlbum();

$db->disconnect(); 

header('Location: ' . $_SERVER['HTTP_REFERER']);
	

?> 