<?php

function findEntry($name) {

	if($name != 'Wall Post' && $name != 'Profile Photos' && $name != 'For Sale') {
		$query = "select albumid from album where timestamp=curdate() and name!='Wall Post' && name != 'Profile Photos' && name != 'For Sale' and userid=" . $_SESSION['home_user'];
	} else {
		$query = "select albumid from album where name='$name' and userid=" . $_SESSION['home_user'];
	}
	
	$result = mysql_query($query);

	if($result == false){
		die(mysql_error()); 
	}

	if(mysql_num_rows($result) == 0) {
		$query = "insert into album values ('', '$name', curdate(), ". $_SESSION['home_user'] . ", 1)";
		$result = mysql_query($query);
		
		if($result == false){
			die(mysql_error()); 
		}
		
		if($name != 'Wall Post' && $name != 'Profile Photos' && $name != 'For Sale') {
			$query = "select albumid from album where timestamp=curdate() and name!='Wall Post' && name != 'Profile Photos' && name != 'For Sale' and userid=" . $_SESSION['home_user'];
		} else {
			$query = "select albumid from album where name='$name' and userid=" . $_SESSION['home_user'];
		}
		
		$result = mysql_query($query);
		
		if($result == false){
			die(mysql_error()); 
		}
	}
	

	$row = mysql_fetch_array($result);
	$albumid = $row['albumid'];
	
	
	return $albumid;
}

 
function addToAlbum() {

	$query = "select count(*) from photos where photos.userid=" . $_SESSION['home_user'];
	$tmp = mysql_query($query);
	$photo_num = mysql_fetch_array($tmp);
	
	if($photo_num[0] >= 50) {
		return;
	}

	include('image.php'); 

	list($dir_thumb, $dir_big) = uploadImage();
	
	if($dir_big == "") {
		return $dir_big;
	}

	$albumid = 0;

	if(isset($_REQUEST['album']) == true) {
		$albumid = $_REQUEST['album'];
	} else if(isset($_REQUEST['name']) == true) {
		$albumid = findEntry($_REQUEST['name']);
		$albumid = findEntry($_REQUEST['name']);
	} else {
		$albumid = findEntry(date('d M Y'));
	}

	$query = "insert into photos values (" . $_SESSION['home_user'] . ", '$dir_big', '$dir_thumb', '', NOW(), $albumid)";
	$result = mysql_query($query);

	if($result == false){
		die(mysql_error()); 
	}
	
	echo $query;
	return $dir_big;
	
}

function addPhotoToAlbum($dir_big, $dir_thumb, $albumname = "") {

	if($dir_big == "") {
		return $dir_big;
	}
	
	if($albumname != "") {
		$albumid = findEntry($albumname);
	} else if(isset($_REQUEST['album']) == true) {
		$albumid = $_REQUEST['album'];
	} else if(isset($_REQUEST['name']) == true) {
		$albumid = findEntry($_REQUEST['name']);
	} else {
		$albumid = findEntry(date('d M Y'));
	}

	$query = "insert into photos values (" . $_SESSION['home_user'] . ", '$dir_big', '$dir_thumb', '', NOW(), $albumid)";
	$result = mysql_query($query);

	if($result == false){
		die(mysql_error()); 
	}
	
	$query = "select max(imageid) from photos";
	$result = mysql_query($query);

	if($result == false){
		die(mysql_error()); 
	}
	
	$row = mysql_fetch_array($result);
	
	return $row[0];
	
}

function showAlum($query, $userid, $friend_status) {

	$result = mysql_query($query);

	$count = 0;

	if($result){
			
		while($row = mysql_fetch_array($result)){
		
			if($row['privacy'] >= $friend_status) {
				if($count == 0) {
					echo "<tr>";
				}
				
				if($userid == $_SESSION['home_user']) {
					echo "<td><a href='" . $row['image'] . "' rel=\"lightbox[album]\" title=\"<center><a href='delete_photo.php?id=" . $row['imageid'] . "'>Delete Photo</a>&nbsp;&nbsp;&nbsp;<a href='change_profile.php?id=" . $row['imageid'] . "'>Set Profile Photo</a></center>\"><img src='" . $row['image'] . "' width=150px height=150px></a>";
				} else {
					echo "<td><a href='" . $row['image'] . "' rel=\"lightbox[album]\" title=\"\"><img src='" . $row['image'] . "' width=150px height=150px></a>";
				}
				
				$count = $count + 1;
				if($count >= 4) {
					$count = 0;
				}
			}
		}
	} else {

		die(mysql_error()); 
	}
}

?>