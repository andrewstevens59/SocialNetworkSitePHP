<?php

include('connectMySQL.php'); 
  
  session_start();

$query = "delete from product where productid=" . $_REQUEST['id'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}


$db->disconnect(); 


header('Location: buy_sell.php?l_p');

	

?> 