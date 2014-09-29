<?php


$type = "";

if(isset($_REQUEST['type'])) {
	$type = mysql_real_escape_string($_REQUEST['type']);
}

include('connectMySQL.php'); 


$query = "select thumb, firstname, surname, userid from user where userid in (select userid1 from messages where messages.new=true)";

$result = mysql_query($query);

if($result){


	while($row = mysql_fetch_array($result)){
		echo "<div onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"window.location = 'new_message.php?user=" . $row ['userid'] . "'\"><table><tr>";
		echo "<td><img src='" . $row ['thumb'] . "'>";
		echo "<td><b>" .$row ['firstname'] . " " . $row ['surname'] ."</b><br>";
		echo "</table></div>";
	}
	

} else {
	die(mysql_error()); // useful for debug
}

$db->disconnect();


?>