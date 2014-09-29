<div id='new_page'>

<?php


session_start();


include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$query = "select user.thumb, firstname, surname, message, photo, wallid, user.userid from wall, user where user.userid=wall.userid1 and wall.wallid=" . $_REQUEST['user'] . " order by wall.timestamp desc";

include('wall_posting.php');

displayWall($query, $_SESSION['home_user'], "Wall Post", "show_alert.php?user=" . $_REQUEST['user']);


$db->disconnect(); // disconnect after use is a good habit


?>

</div>