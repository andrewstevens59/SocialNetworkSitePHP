<?php


function checkAccessRights($userid, $pagetype) {

	if($userid == $_SESSION['home_user']) {
		return;
	}

	$query = "select $pagetype from privacy where userid=$userid";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	if($row[$pagetype] == 0) {
		die("<div class='rounded-corners'><font size=3><b><center>You Don't Have Access Rights</center></b></font></div>");
	}
	
	if($row[$pagetype] != 2) {
	
		$query = "select * from friends where userid1=$userid and userid2=" . $_SESSION['home_user'];
		$result = mysql_query($query);
		
		if($result == false) {
			die(mysql_error()); 
		}
		
		if(mysql_num_rows($result) == 0) {
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			die("<center><div class='rounded-corners'><font size=3><b>You Don't Have Access Rights</b></font><br><a href='request_friend.php?user=$userid'>Request This Person As A Friend</a></center></div></center>");
		}
	}

}

?>