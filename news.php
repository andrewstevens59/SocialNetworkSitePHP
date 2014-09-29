<div id='new_page'>

<?php


session_start();

include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$query = "select wall.timestamp, user.thumb, firstname, surname, message, photo, wallid, user.userid from wall, user, friends where user.userid=wall.userid1 and wall.userid1=friends.userid2 and friends.userid1=" . $_SESSION['home_user'] . " union select wall.timestamp, user.thumb, firstname, surname, message, photo, wallid, user.userid from wall, user, friends where user.userid=wall.userid1 and user.userid=" . $_SESSION['home_user'] . "  order by 1 desc limit $num";


include('wall_posting.php');

displayWall($query, $_SESSION['home_user'], "News", "news.php");


$db->disconnect(); // disconnect after use is a good habit


?>

</div>