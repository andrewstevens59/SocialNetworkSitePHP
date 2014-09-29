<?php


session_start();


include('connectMySQL.php'); 

$query = "delete from meetup_pool where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);


$db->disconnect(); // disconnect after use is a good habit

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>