<div id="view_image" style="border: 1px solid black; background-color: rgb(255, 255, 255); z-index:100; top:25%; left:25%; display:none;  position: absolute;" onmouseover='is_set=true;' onmouseout='is_set=false;'></div>
	
	
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>

<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />

<style>

#lightbox[album]{
	width:300px;
	height:300px;
}


</style>

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
	
	$albumid = 0;
	if(isset($_REQUEST['name']) == true) {
	
		$query = "select album.albumid from album, photos where photos.albumid=album.albumid and name='" . $_REQUEST['name'] . "' and photos.userid=$userid";
		$result = mysql_query($query);
		
		$row = mysql_fetch_array($result);
		$albumid = $row[0];
	} else {
		$albumid = $_REQUEST['album'];
	}

?>

	<script type="text/javascript">
	
	
	function viewImage(image, id) {
	
		var text = "<img src='" + image + "' width=50% height=50%><p>";
		
<?php
		echo "if($userid == " . $_SESSION['home_user'] . ") {";
?>

		text += "<a href='change_profile.php?id=" + id + "'>set as profile photo</a>";
		text += "&nbsp;&nbsp;<a href='delete_photo.php?id=" + id + "'>delete photo</a>";
		
		}
		
		document.getElementById("view_image").innerHTML = text;
		document.getElementById("view_image").style.display="block";


	}
	
	</script>

<?php

$query = "select name, privacy from album where album.albumid=$albumid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

echo "<div class='layout' ><font size=6><b>Album <img src='arrow.jpg' width=20px height=20px> " . $row['name'] . "</b></font></div><p>";

$query = "select count(*) from photos where photos.userid=$userid";
$tmp = mysql_query($query);
$photo_num = mysql_fetch_array($tmp);

if($userid == $_SESSION['home_user']) {

echo "<p><div class='layout'><center><table>";

if($photo_num[0] >= 50) {
	echo "Sorry limited to 50 photos, delete some of your old photos to upload new ones</center><p>";
} else {

	
	echo "<form action=\"upload_image.php?album=$albumid\" method=\"post\" enctype=\"multipart/form-data\">";
	
?>

<td></td>
<td><input type="file" name="image"></td>
<td><input type="image" VALUE="Submit" src='upload1.jpg' onmouseover='this.src="upload2.jpg"' onmouseout='this.src="upload1.jpg"'></td></form>

<?php

}

echo "<form action=\"save_album_details.php?album=$albumid\" method=\"post\" enctype=\"multipart/form-data\">";

?>

<tr>
<td>

<?php


if( $row['name'] != 'Wall Post' && $row['name'] != 'Profile Photos') {
	echo "<label for='name'>Album Name</label>";
	echo "<input type=\"text\" name=\"name\" value=\"" . $row['name'] ."\" size=40>";
} else {
	echo "<input type=\"text\" name=\"name\" style=\"display:none;\" value=\"" . $row['name'] ."\" size=40>";
}


?>

<td><center><b>Visible To</b> <select name="privacy" size="1">
<?php
displayViewingRights($row['privacy']);
?>
</select></center></td>


<td><input type="image" VALUE="Submit" src='save1.jpg' onmouseover='this.src=\"save2.jpg\"' onmouseout='this.src=\"save1.jpg\"'></td>


</form>

<?php


echo "</table></center></div><p>";



}



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

echo "<p><div class='layout'><center><table><p>";
$query = "select image, imageid, privacy from photos, album where photos.userid=$userid and album.albumid=$albumid and album.albumid=photos.albumid";

include('add_to_album.php');
showAlum($query, $userid, $friend_status);

$db->disconnect(); 

echo "</table></center></div></table>";


?>