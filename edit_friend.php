<?php


session_start();
include('connectMySQL.php'); 


include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$userid = $_SESSION['home_user'];
if(isset($_REQUEST['user'])) {
	$userid = $_REQUEST['user'];
}

$query = "select in_rel from privacy where userid = " . $_SESSION['home_user'];
$result = mysql_query($query);

$privacy = mysql_fetch_array($result);

$query = "select comfortability, relid, firstname, surname, status from friends, user where user.userid=friends.userid1 and friends.userid2=$userid and friends.userid1 = " . $_SESSION['home_user'];
$result = mysql_query($query);

if($result){

$row = mysql_fetch_array($result);

echo "<div class='layout'><font size=6><b>" . $row['firstname'] . " " . $row['surname'] . " <img src='arrow.jpg'  width=20px height=20px> Relationship</b></font></div><p>";
echo "<div class='layout'>";

echo "<p><form action=\"save_friend_details.php?user=$userid\" method=\"post\" enctype=\"multipart/form-data\">";

?>
		
<legend></legend>

<table width=100%>


<tr>
<td><label for="comfortability">Describe your relationsip with this person<br><i>(Changes the priority order of your friends for invites)</i></label>
<td><select name="comfortability" size="1">


<?php


if($row['comfortability'] == 0) {
	echo "<option value=0>acquaintances (1)";
} else if($row['comfortability'] == 1) {
	echo "<option value=1>talk occasionally (2)";
} else if($row['comfortability'] == 2) {
	echo "<option value=2>friends (3)";
} else if($row['comfortability'] == 3) {
	echo "<option value=3>I would like to get to know this person better (4)";
} else if($row['comfortability'] == 4) {
	echo "<option value=4>good friends (5)";
} else {
	echo "<option value=5>best friends (6)";
}

?>

<option value="0">acquaintances (1)
<option value="1">talk occasionally (2)
<option value="2">friends (3)
<option value="3">I would like to get to know this person better (4)
<option value="4">good friends (5)
<option value="5">best friends (6)
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

<tr>
<td><label for="is_rel">Describe Your Relationship</label><td width=50%><table><tr><td>
<td><select name="status" size="1">


<?php

	if($row['status'] == 0) {
		echo "<option value=0>No Relationship<option value=1>In a relationship<option value=2>Engaged<option value=3>Married<option value=4>In an open relationship";
	} else if($row['status'] == 1) { 
		echo "<option value=1>In a relationship<option value=0>No Relationship<option value=2>Engaged<option value=3>Married<option value=4>In an open relationship";
	} else if($row['status'] == 2) {
		echo "<option value=2>Engaged<option value=0>No Relationship<option value=1>In a relationship<option value=3>Married<option value=4>In an open relationship";
	} else if($row['status'] == 3) { 
		echo "<option value=3>Married<option value=0>No Relationship<option value=1>In a relationship<option value=2>Engaged<option value=4>In an open relationship";
	} else {
		echo "<option value=4>In an open relationship<option value=3>Married<option value=0>No Relationship<option value=1>In a relationship<option value=2>Engaged";
	}
?>

</select>
<td width=5%><td width=100%><b>Visible To</b> <select name="rel_priv" size="1">
<?php
displayViewingRights($privacy['in_rel']);
?>
</select></table>

<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<tr>
<td><input type="image" VALUE="Submit" src='save1.jpg' onmouseover='this.src="save2.jpg"' onmouseout='this.src="save1.jpg"'>

</table>
</form></div><p>

<div class='layout'><center>
Do you want to remove <b>

<?php

echo "<a href='user_page.php?user=$userid'>" . $row['firstname'] . " " . $row['surname'] . "</a></b> as a friend <a href='drop_friend.php?user=$userid'>Drop Friend</a></td>";

?>
</center></div>

<?php

} else {

	die(mysql_error()); 
}

$db->disconnect(); 


?>