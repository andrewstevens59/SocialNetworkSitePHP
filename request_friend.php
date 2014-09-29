<?php

  
  session_start();

$userid2 = mysql_real_escape_string($_REQUEST['user']);

include('connectMySQL.php'); 

$query = "insert into friend_request values (" .$_SESSION['home_user'] . ",$userid2, now())";
$result = mysql_query($query);

$query = "update alerts set friends=friends+1 where userid=$userid2";
$temp = mysql_query($query);

$db->disconnect(); // disconnect after use is a good habit


header('Location: ' . $_SERVER['HTTP_REFERER']);

?> 