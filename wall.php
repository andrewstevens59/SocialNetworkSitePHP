<div id='new_page'>

<?php


session_start();

include('connectMySQL.php'); 

$userid = $_SESSION['home_user'];
if(isset($_REQUEST['user'])) {
	$userid = $_REQUEST['user'];
}

include('banner.php');
drawBanner(false, $userid);

include('check_privacy.php');
checkAccessRights($userid, "wall");



$query = "select user.thumb, firstname, surname, message, photo, wallid, user.userid from wall, user where wall.userid2=$userid and user.userid=wall.userid1 order by wall.timestamp desc limit $num";

include('wall_posting.php');

displayWall($query, $userid, "Wall", "wall.php?user=$userid");


$db->disconnect();


?>

</div>