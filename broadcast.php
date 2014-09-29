<div id='new_page'>

<?php


session_start();

include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$query = "select wall.timestamp, user.thumb, firstname, surname, message, photo, wallid, user.userid, privacy from wall, user where user.userid=wall.userid1 order by 1 desc limit $num";


include('wall_posting.php');

displayWall($query, $_SESSION['home_user'], "Broadcast <br><font color='blue'>(share your thoughts with everyone)</font>", "broadcast.php");


$db->disconnect(); // disconnect after use is a good habit


?>

</div>