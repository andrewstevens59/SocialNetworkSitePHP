<?php

include('connectMySQL.php'); 

$album = $_REQUEST['album'];
$name = $_REQUEST['name'];
$privacy = $_REQUEST['privacy'];

$query = "update album set privacy=$privacy, name='$name' where albumid=$album";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}


header('Location: ' . $_SERVER['HTTP_REFERER']);

?>