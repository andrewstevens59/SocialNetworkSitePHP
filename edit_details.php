

<?php


session_start();

include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$query = "select courses, dob, description, degree, ethnicity, highschool, university, employers from privacy where userid = " . $_SESSION['home_user'];
$result = mysql_query($query);
$privacy = mysql_fetch_array($result);

$query = "select UNIX_TIMESTAMP(dob), ethnicity, entrepreneur, questions, gender, highschool, university, employers, thumb, image, firstname, surname, description, degree, status, interestedin, courses, userid from user where userid = " . $_SESSION['home_user'];
$result = mysql_query($query);

if($result){

echo "<div class='layout'><font size=6><b>Edit Details</b></font></div><p>";
		
	if($row = mysql_fetch_array($result)){

?>

<p><div class='layout'>
<form action="save_details.php" method="post"
enctype="multipart/form-data">
<legend></legend>

<table>


<tr>
<td><label for="description">Description</label>

<?php

echo "<td><textarea name=\"description\" cols=\"50\" rows=\"3\">" .$row['description'] . "</textarea><br>";

?>

<td><b>Visible To</b> <select name="description_priv" size="1">
<?php
displayViewingRights($privacy['description']);
?>
</select>

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

</select>
<td><b>Visible To</b> <select name="ethnicity_priv" size="1">
<?php
displayViewingRights($privacy['ethnicity']);
?>
</select>

<tr>
<td><label for="interestedin">Interested In</label>
<td><select name="interestedin" size="1">

<?php

	if($row['interestedin'] == 0) {
		echo "<option value=0><option value=1>Men<option value=2>Women";
	} else if($row['interestedin'] == 1) { 
		echo "<option value=1>Men<option value=0><option value=2>Women";
	} else {
		echo "<option value=2>Women<option value=0><option value=1>Men";
	}

?>


</select>
<td>

<tr>
<td><label for="gender">Gender</label>
<td><select name="gender" size="1">

<?php

if($row['gender'] == 1) {
	echo "<option value=1>Male<option value=0>Female";
} else {
	echo "<option value=0>Female<option value=1>Male";
}

?>

</select>
<td>

<tr>
<td><label for="status">Relationship Status</label>
<td><select name="status" size="1">


<?php

	if($row['status'] == 0) {
		echo "<option value=0>Single<option value=1>In a relationship<option value=2>Engaged<option value=3>Married<option value=4>In an open relationship";
	} else if($row['status'] == 1) { 
		echo "<option value=1>In a relationship<option value=0>Single<option value=2>Engaged<option value=3>Married<option value=4>In an open relationship";
	} else if($row['status'] == 2) {
		echo "<option value=2>Engaged<option value=0>Single<option value=1>In a relationship<option value=3>Married<option value=4>In an open relationship";
	} else if($row['status'] == 3) { 
		echo "<option value=3>Married<option value=0>Single<option value=1>In a relationship<option value=2>Engaged<option value=4>In an open relationship";
	} else {
		echo "<option value=4>In an open relationship<option value=3>Married<option value=0>Single<option value=1>In a relationship<option value=2>Engaged";
	}

?>

</select>
<td>

<tr><td>Date of Birth <td>
<table><tr>
<td><select name="day" size="1">

<?php

	echo "<option value=" . date("d", $row[0]) . ">" . date("d", $row[0]);

	for($i=1; $i<32; $i++) {
		if($i < 10) {
			echo "<option value=$i>0$i";
		} else {
			echo "<option value=$i>$i";
		}
	}

?>

</select>

<td><select name="month" size="1">

<?php

	echo "<option value=" . date("m", $row[0]) . ">" . date( 'F', mktime(0, 0, 0, date("m", $row[0])) );

	for($i=1; $i<13; $i++) {
		echo "<option value=$i>" . date( 'F', mktime(0, 0, 0, $i) );
	}

?>

</select>

<td><select name="year" size="1">

<?php

	echo "<option value=" . date("y", $row[0]) . ">" . date("Y", $row[0]);
	
	for($i=1970; $i<=2000; $i++) {
		echo "<option value=$i>$i";
	}

?>

</select>

</table>
<td><b>Visible To</b> <select name="dob_priv" size="1">
<?php
displayViewingRights($privacy['dob']);
?>
</select>

<tr>
<td><label for="degree">Degree</label>

<?php

echo "<td><input type=\"text\" name=\"degree\" value=\"" . $row['degree'] ."\" size=60>";

?>

<td><b>Visible To</b> <select name="degree_priv" size="1">
<?php
displayViewingRights($privacy['degree']);
?>
</select>


<tr>
<td><label for="courses">Enrolled Courses<br><i>(course code only)</i></label>

<?php

echo "<td><input type=\"text\" name=\"courses\" value=\"" . $row['courses'] ."\" size=60>";

?>

<td><b>Visible To</b> <select name="courses_priv" size="1">
<?php
displayViewingRights($privacy['courses']);
?>
</select>

<tr>
<td><label for="highschool">Highschool</label>

<?php

echo "<td><input type=\"text\" name=\"highschool\" value=\"" . $row['highschool'] ."\" size=60>";

?>

<td><b>Visible To</b> <select name="highschool_priv" size="1">
<?php
displayViewingRights($privacy['highschool']);
?>
</select>

<tr>
<td><label for="university">University</label>

<?php

echo "<td><input type=\"text\" name=\"university\" value=\"" . $row['university'] ."\" size=60>";

?>

<td><b>Visible To</b> <select name="university_priv" size="1">
<?php
displayViewingRights($privacy['university']);
?>
</select>

<tr>
<td><label for="employers">Employers</label>

<?php

echo "<td><input type=\"text\" name=\"employers\" value=\"" . $row['employers'] ."\" size=60>";


?>

<td><b>Visible To</b> <select name="employers_priv" size="1">
<?php
displayViewingRights($privacy['employers']);
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
<tr><td colspan="3">
<hr>
<table style="background-color:#F2F2F2;" width="800">

<tr>
<td>
<center><b>This information is kept private. It's only used to help you find people similar to you.<br>Used in <a href='meetup_pool.php'>meetup pool</a>, <a href='show_activity.php?id=32'>Group Date</a> and <a href='show_activity.php?id=29'>Meet New People</a><p> You must answer all question before being allowed to particpate in the activities above</b></center><p><td>
<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>

<div class='layout' style='overflow: auto;height:300px;'>
<table>
<tr>
<td>

<?php


$qs[0] = "You like to be engaged in an active and fast-paced job";
$qs[1] = "You enjoy having a wide circle of acquaintances";
$qs[2] = "You are more interested in a general idea than in the details of its realization";
$qs[3] = "Objective criticism is always useful in any activity";
$qs[4] = "You prefer to act immediately rather than speculate about various options";
$qs[5] = "You are inclined to rely more on improvisation than on careful planning";
$qs[6] = "You spend your leisure time actively socializing with a group of people, attending parties, shopping, etc.";
$qs[7] = "You usually plan your actions in advance";
$qs[8] = "You are a person somewhat reserved and distant in communication";
$qs[9] = "You know how to put every minute of your time to good purpose";
$qs[10] = "You readily help people while asking nothing in return";
$qs[11] = "You often contemplate about the complexity of life";
$qs[12] = "After prolonged socializing you feel you need to get away and be alone";
$qs[13] = "You often do jobs in a hurry";
$qs[14] = "You get bored if you have to read theoretical books";
$qs[15] = "You tend to sympathize with other people";
$qs[16] = "You rapidly get involved in social life at a new workplace";
$qs[17] = "The more people with whom you speak, the better you feel";
$qs[18] = "You like to keep a check on how things are progressing";
$qs[19] = "You tend to rely on your experience rather than on theoretical alternatives";
$qs[20] = "Often you prefer to read a book than go to a party";
$qs[21] = "You enjoy being at the centre of events in which other people are directly involved";
$qs[22] = "You are more inclined to experiment than to follow familiar approaches";
$qs[23] = "You prefer to isolate yourself from outside noises";
$qs[24] = "It&#39;s essential for you to try things with your own hands";
$qs[25] = "You think that almost everything can be analysed";
$qs[26] = "You feel at ease in a crowd";
$qs[27] = "You easily understand new theoretical principles";
$qs[28] = "The process of searching for a solution is more important to you than the solution itself";
$qs[29] = "When solving a problem you would rather follow a familiar approach than seek a new one";
$qs[30] = "You prefer meeting in small groups to interaction with lots of people";
$qs[31] = "When considering a situation you pay more attention to the current situation and less to a possible sequence of events";
$qs[32] = "You often spend time thinking of how things could be improved";
$qs[33] = "You prefer to spend your leisure time alone or relaxing in a tranquil family atmosphere";
$qs[34] = "You are always looking for opportunities";
$qs[35] = "As a rule, current preoccupations worry you more than your future plans";
$qs[36] = "It is easy for you to communicate in social situations";
$qs[37] = "You are consistent in your habits";
$qs[38] = "I have a tendency to be serious about things at times";
$qs[39] = "I like to find solutions to practical problems over that of theoretical ones";
$qs[40] = "I have a good intuition about others and interested in understanding them;";
$qs[41] = "I like to be individualistic rather than leading or following";
$qs[42] = "I require no interaction with others to feel good about myself";
$qs[43] = "I have little patience for inefficiency or disorganization";
$qs[44] = "I&#39;m very adaptable and laid back";
$qs[45] = "I love new experiences all the time";
$qs[46] = "I have little interest in theory or abstraction";
$qs[47] = "I&#39;m good at organizing myself and others";
$qs[48] = "I avoid conflict";
$qs[49] = "I am able to concentrate on problems for a very long period of time";
$qs[50] = "I work steadily towards goals I have identified for myself";
$qs[51] = "I&#39;m a creative thinker and enjoy creative problem solving";
$qs[52] = "I&#39;m happy with my life right now and don&#39;t think a lot about the future";




for($i=0; $i<55; $i++) {

	echo "<tr><td>";
	
	if(strlen($row['questions']) <= $i) {
		echo "<font color='red'><b>X &nbsp;&nbsp;</b></font>";
		
		echo $qs[$i];
		echo "<hr color='white'>";
	
		echo "<td vlign=middle><input type='radio' name='q$i' value=1 /><td> Yes";
		echo "<td vlign=middle><input type='radio' name='q$i' value=0 /><td> No";
		continue;
	}

	if($row['questions'][$i] == 'x') {
		echo "<font color='red'><b>X &nbsp;&nbsp;</b></font>";
	}
	
	echo $qs[$i];
	echo "<hr color='white'>";
	
	if($row['questions'][$i] == '1') {
		echo "<td vlign=middle><input type='radio' name='q$i' value=1 checked /><td> Yes";
	} else {
		echo "<td vlign=middle><input type='radio' name='q$i' value=1 /><td> Yes";
	}
	
	if($row['questions'][$i] == '0') {
		echo "<td vlign=middle><input type='radio' name='q$i' value=0 checked /><td> No";
	} else {
		echo "<td vlign=middle><input type='radio' name='q$i' value=0 /><td> No";
	}
}


?>

</table></div>



</table>

<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>

<tr>
<td><input type="image" VALUE="Submit" src='save1.jpg' onmouseover='this.src=\"save2.jpg\"' onmouseout='this.src=\"save1.jpg\"'>

</table>


</form>
</div>

</div>



<?php

}
} else {

	die(mysql_error()); 
}

$db->disconnect(); 


?>


