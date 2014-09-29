<div id='new_page'>

<?php


session_start();


include('connectMySQL.php'); 


include('banner.php');
drawBanner(false, $_SESSION['home_user']);

echo "<div class='layout'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Blind Meetups </b></font></div><p>";

echo "<table width=92%><tr><td><div class='rounded-corners'><div style='background-color:white'><center><img src='blind_meetup.jpg'></center></div><div style='background-color:#F2F2F2'><font size=3>";
echo "Blind meetups is an arranged meeting between two individuals who have been chosen at random. ";
echo "<p>Blind meetups are usually more commonly associated with <b>romantic interests</b>. So let fate take over.";
echo "<p>Only individuals <b>who have requested</b> a meetup will be assigned a time and place to meet at <b>St Lucia Campus</b>.";
echo "<p>Blind meetups are designed to allow you to meet people you ordinarily wouldn't. ";
echo "<p>Blind meetups should last no longer than <b>5 minutes</b>.";
echo "<p>After the meetup you have the opportunity to request an individual meetup (see <a href='individual_meetups.php'>Individual Meetups</a>).";
echo "<p>Individual meetups then allow you to get to know the person better.";
echo "<p>Individual meetups are only arranged if <b>both individuals have requested it</b>.";
echo "</font></div></div></table><p>";

$query = "select UNIX_TIMESTAMP(timestamp) from last_n_activities where userid=" . $_SESSION['home_user'] . " and activitytypeid=33 order by timestamp desc limit 1";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$row = mysql_fetch_array($result);

$prev_date = date("Y-m-d", $row[0]);
$datetime1 = new DateTime($prev_date);
$datetime2 = new DateTime();
$interval = $datetime1->diff($datetime2);
$interval = intval($interval->format('%R%a'));

if( $interval < 2) {
	echo "<div class='layout'><center><b>Cannot Request This Activity For Another " . (2 - $interval) . " days</b></center></div>";
	echo "</table>";
	$db->disconnect();
	return;
}

$query = "select * from blind_date where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);


if($result){


	if(mysql_num_rows($result) > 0) {
		echo "<div class='layout'><a href='delete_blind_request.php');return false;'><center><img src='req_blind_meetup2.jpg'></center></a>";
		echo "<center>You will be envited to attend a blind metup when another member with matching criteria has requested it</center></div>";
		
		echo "</table>";
		$db->disconnect();
		return;
	} 

} else {
	die(mysql_error()); // useful for debug
}

?>

<div class='layout'>
<form ACTION="request_blind_meetup.php" METHOD=POST>
<legend></legend>

<table>

<tr>
<td><label for="firstname">Seeking</label>
<td><select name="seeking">

<?php

$query = "select ethnicity, status, interestedin, gender from user where userid=" . $_SESSION['home_user'];
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$row = mysql_fetch_array($result);

if($row['interestedin'] == 0) {
	if($row['gender'] == 1) {
		echo "<option value=\"1\">Females seeking Males";
		echo "<option value=\"5\">Males seeking Males";
	} else {
		echo "<option value=\"0\">Males seeking Females";
		echo "<option value=\"6\">Females seeking Females";
	}
} else if($row['interestedin'] == 1) {

	if($row['gender'] == 1) {
		echo "<option value=\"5\">Males seeking Males";
		echo "<option value=\"1\">Females seeking Males";
	} else {
		echo "<option value=\"0\">Males seeking Females";
		echo "<option value=\"6\">Females seeking Females";
	}
} else {

	if($row['gender'] == 0) {
		echo "<option value=\"6\">Females seeking Females";
		echo "<option value=\"0\">Males seeking Females";
	} else {
		echo "<option value=\"1\">Females seeking Males";
		echo "<option value=\"5\">Males seeking Males";
	}
}

?>


<tr>
<td><label for="ethnicity">Ethnicity</label>
<td><select name="ethnicity" size="1">

<?php

	if($row['ethnicity'] == 0) {
		echo "<option value=0>White (Caucaisian)";
	} else if($row['ethnicity'] == 1) { 
		echo "<option value=1>Hispanic";
	} else if($row['ethnicity'] == 2) {
		echo "<option value=2>Indigeneous Native";
	} else if($row['ethnicity'] == 3) {
		echo "<option value=3>African American";
	} else if($row['ethnicity'] == 4) {
		echo "<option value=4>Mediterranean";
	} else if($row['ethnicity'] == 5) {
		echo "<option value=5>West Indian ";
	} else if($row['ethnicity'] == 6) {
		echo "<option value=6>Maori";
	} else if($row['ethnicity'] == 7) {
		echo "<option value=7>African";
	} else if($row['ethnicity'] == 8) {
		echo "<option value=8>Asian";
	} else if($row['ethnicity'] == 9) {
		echo "<option value=9>Indian";
	} else if($row['ethnicity'] == 10) {
		echo "<option value=10>Latino";
	} else if($row['ethnicity'] == 11) {
		echo "<option value=11>Middle Eastern";
	} else {
		echo "<option value=12>Other";
	}

?>

<option value=0>White (Caucaisian)
<option value=1>Hispanic
<option value=2>Indigeneous Native
<option value=3>African American
<option value=4>Mediterranean
<option value=5>West Indian 
<option value=6>Maori
<option value=7>African
<option value=8>Asian
<option value=9>Indian
<option value=10>Latino
<option value=11>Middle Eastern
<option value=12>Other
<option value=13>Any

</select>

<tr>
<td><label for="firstname">Age range</label>
<td><table><tr><td><select name="age_start">

<?php

for($i=18; $i<30; $i++) {
	echo "<option name=$i>$i";
}

?>

<td>to
<td><select name="age_end">

<?php

echo "<option name=24>24";

for($i=18; $i<30; $i++) {
	echo "<option name=$i>$i";
}

?>

</table>
</table>


</div><p>

<div class='layout'>
<center><input type="image" VALUE="Submit" src='req_blind_meetup1.jpg' onmouseover='this.src="req_blind_meetup3.jpg"' onmouseout='this.src="req_blind_meetup1.jpg"'></center>
</form>

<?php


echo "</table>";
$db->disconnect(); 


?>

</div>