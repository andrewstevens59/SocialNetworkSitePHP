
<?php

session_start();


include('connectMySQL.php'); 

$query = "delete from user_reject_activity where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

$query = "select activitytypeid from categories";
$result = mysql_query($query);

if($result){
	
	while($row = mysql_fetch_array($result)){

		if(isset($_REQUEST[ strval($row['activitytypeid'])]) == false) {
			$query = "insert into user_reject_activity values (" . $_SESSION['home_user'] . ", " . $row['activitytypeid'] . ")";
			$tmp = mysql_query($query);
		}
	}
	
} else {
	die(mysql_error()); // useful for debug
}

$db->disconnect(); // disconnect after use is a good habit

header("Location: activities.php");
	

?>