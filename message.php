<?php


session_start();


$user_id = $_SESSION['USER_ID'];


include('connectMySQL.php'); 



$query = "select * from messages where USER_ID = '" .$user_id ."'";
$result = mysql_query($query);

if($result){
	while($row = mysql_fetch_array($result)){
	$count = 1;
	}
	
} else {
	die(mysql_error()); // useful for debug
}


$db->disconnect(); // disconnect after use is a good habit



?>