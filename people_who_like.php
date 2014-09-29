<?php

  
  session_start();

$id = $_REQUEST['id'];
$type = $_REQUEST['type'];

include('connectMySQL.php'); 

$query = "select user.userid, thumb, firstname, surname from $type, user where id=$id and user.userid=$type.userid";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

while($row = mysql_fetch_array($result)){

	echo "<div onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'user_page.php?user=" . $row ['userid'] . "'\"><table><tr>";
	echo "<td><img src='" . $row ['thumb'] . "' width=70px height=70px>";
	echo "<td><b>" .$row ['firstname'] . " " . $row ['surname'] ."</b> likes this";
	echo "</table></div>";
}

$db->disconnect(); 

	

?> 