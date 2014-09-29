
<?php


session_start();

include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);



echo "<div class='layout'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Search For Members </b></font></div><p>";

?>

<div class='layout'>
<form ACTION="browse_pool.php" METHOD=POST>
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
		echo "<option value=\"1\">Female";
	} else {
		echo "<option value=\"0\">Male";
	}
} else if($row['interestedin'] == 1) {

	if($row['gender'] == 1) {
		echo "<option value=\"5\">Males seeking Males";
	} else {
		echo "<option value=\"3\">Males seeking Females";
	}
} else {

	if($row['gender'] == 0) {
		echo "<option value=\"6\">Females seeking Females";
	} else {
		echo "<option value=\"4\">Females seeking Males";
	}
}

?>

<option value="0">Male
<option value="1">Female
<option value="2">Male or Female
<option value="3">Males seeking Females
<option value="4">Females seeking Males
<option value="5">Males seeking Males
<option value="6">Females seeking Females

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

<tr><td>
<input type='checkbox' name='online'>
<td width=70%><b>users currently online</div>

<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td><input type="image" VALUE="Submit" src='search1.jpg' onmouseover='this.src="search2.jpg"' onmouseout='this.src="search1.jpg"'>

</table>
</form>

<p>
<center>(To find other people like <b>you</b> make sure you fill out you <a href='edit_details.php'>personality profile</a>)</center>
</div>