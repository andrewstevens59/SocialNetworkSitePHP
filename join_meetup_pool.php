<?php


session_start();


include('connectMySQL.php'); 

$query = "insert into meetup_pool values (" . $_SESSION['home_user'] . ")";
$result = mysql_query($query);


$db->disconnect(); // disconnect after use is a good habit

header('Location: ' . $_SERVER['HTTP_REFERER']);


?>