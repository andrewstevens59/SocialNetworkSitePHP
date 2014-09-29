<?php


session_start();

include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);


$query = "select photos, information, friends, wall, meetups from privacy where userid = " . $_SESSION['home_user'];
$result = mysql_query($query);

if($result){

echo "<div class='layout' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Information </b></font></div><p>";
echo "<div class='layout'>";

$row = mysql_fetch_array($result);

?>
		
	<p>
<form action="save_privacy.php" method="post"
enctype="multipart/form-data">
<legend></legend>

<table>


<tr>
<td><label for="photos"><b>Photos</b> Viewed By</label>
<td><select name="photos" size="1">

<?php
displayViewingRights($row['photos']);
?>

</select>

<tr>
<td><label for="information"><b>Information</b> Viewed By</label>
<td><select name="information" size="1">

<?php
displayViewingRights($row['information']);
?>
</select>

<tr>
<td><label for="friends"><b>Friends</b> Viewed By</label>
<td><select name="friends" size="1">

<?php
displayViewingRights($row['friends']);
?>

</select>

<tr>
<td><label for="wall"><b>Wall</b> Viewed By</label>
<td><select name="wall" size="1">

<?php
displayViewingRights($row['wall']);
?>

</select>

<tr>
<td><label for="meetups"><b>Meetups</b> Viewed By</label>
<td><select name="meetups" size="1">

<?php
displayViewingRights($row['meetups']);
?>

</select>

<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td><input type="image" VALUE="Submit" src='save1.jpg' onmouseover='this.src="save2.jpg"' onmouseout='this.src="save1.jpg"'>

</table>
</fieldset>
</form></div>

<?php

} else {

	die(mysql_error()); 
}

$db->disconnect(); 


?>