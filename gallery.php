
<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="lightbox/js/lightbox.js"></script>
<link href="lightbox/css/lightbox.css" rel="stylesheet" />


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
	checkAccessRights($userid, "photos");


$friend_status = 1;
$query = "select * from friends where userid1=$userid and userid2=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error()); 
}

if(mysql_num_rows($result) == 0) {
	$friend_status = 2;
}

if($userid == $_SESSION['home_user']) {
	$friend_status = 0;
}

$query = "select firstname, surname from user where userid=$userid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$username = $row['firstname'] . " " . $row['surname'];

echo "<div class='layout' ><b><font size=6>$username <img src='arrow.jpg' width=20px height=20px> Albums</b></font></div><p>";

$count = 0;
$query = "select album.albumid, name, image, privacy from photos, album where photos.userid=$userid and album.albumid=photos.albumid order by album.albumid";
$result = mysql_query($query);

echo "<div class='layout'><center><table width=10%><p>";

if($result){
		
	$currid = -1;
	while($row = mysql_fetch_array($result)){
	
		if($row['albumid'] != $currid && $row['privacy'] >= $friend_status) {
			$currid = $row['albumid'];
			
			if($count == 0) {
				echo "<tr>";
			}
			
			echo "<td valign=top><a href='photos.php?album=" . $row['albumid'] . "&user=$userid'><img style='border: 10px outset blue' src='" . $row['image'] . "' width=150px height=150px></a><br><center><b>" . $row['name'] . "</b></center>";
			
			$count = $count + 1;
			if($count >= 4) {
				$count = 0;
			}
		}
		
		
	}
	
	echo "</table></center></div>";
	
} else {

	die(mysql_error()); 
}

$query = "select count(*) from photos where photos.userid=$userid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

if($userid == $_SESSION['home_user']) {

if($row[0] >= 50) {
	echo "<p><div class='layout'><center>Sorry limited to 50 photos, delete some of your old photos to upload new ones</center></div><p>";
} else {

	?>
		
		<p><div class='layout'><center><form action="upload_image.php" method="post" enctype="multipart/form-data">
	<table>

	<tr>
	<td><input type="file" name="image">
	<td><input type="image" VALUE="Submit" src='upload1.jpg' onmouseover='this.src="upload2.jpg"' onmouseout='this.src="upload1.jpg"'>

	</table>
	</form></center></div>

	<?php

	}

}


echo "<p><div class='layout'><center><table>";
$query = "select image, imageid, privacy from photos, album where album.albumid=photos.albumid and photos.userid=$userid";

include('add_to_album.php');
showAlum($query, $userid, $friend_status);

$db->disconnect(); 

echo "</table></center></div></table>";


?>
