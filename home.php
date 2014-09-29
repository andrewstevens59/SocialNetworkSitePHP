<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
  <head>
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <title>Signup</title>

    <style type="text/css" media="all">
      @import "breadcrumb.css";
	      </style>   
      <script type="text/javascript" src="scripts/mootools.js"></script>
    <script type="text/javascript" src="scripts/w3c-validator.js"></script>
    <script type="text/javascript" src="cookie.js"></script>

    </head>
	
	<style>
	
	html, body
	{
		 margin: 0;
		 padding: 0;
		 background-color:#527ED1;
	}
	
	.layout {
		 -moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		-khtml-border-radius: 10px;
		border-radius: 10px;
		padding: 0.7em;
		background-color:#E6E6FA;
		align:right;
	}
	
	.label {    
	  font-size:25px; 
	  height:25px;
	} 
	
	input {    
	  font-size:20px; 
	}  
	
	select {    
	  font-size:20px; 
	  height:30px;
	}  
	
	</style>

  <body>


<div style="background-image:url('banner.jpg'); width:100%;  height:70px; background-repeat: no-repeat;">

<form ACTION="login.php" METHOD=POST>

<table width=100%>


<tr>

<td width=70%><td><table><tr><td>

<td><font color='white'>Email Address</font><td><font color='white'>Password</font><td>
<tr><td valign=top>

<?php


session_start();

if(isset($_SESSION['error'])) {
	echo "<div style='width:150px'><font color='red' size='5'>" . $_SESSION['error'] . "</font></div>";
}

if(isset($_SESSION['email1']) == false) {
	echo "<td class='label' valign=top><input type='text' name='email' size='20' value='' style='height:25px'><br>";
} else {
	echo "<td class='label' valign=top><input type='text' name='email' size='20' value='" . $_SESSION['email1'] . "' style='height:25px'><br>";
}

if(isset($_SESSION['password1']) == false) {
	echo "<td class='label' valign=top><input type='password' name='password' size='20' value='' style='height:25px' />";
} else {
	echo "<td class='label' valign=top><input type='password' name='password' size='20' value='" . $_SESSION['password1'] . "' style='height:25px' />";
}

?>

<td valign=top><input type="image" src='login1.jpg' VALUE="Submit" onmouseover="this.src='login2.jpg'" onmouseout="this.src='login1.jpg'">
</table>

</table>
</form>
</center>
</div>


<table width=100%><tr><td width=65% valign=top><div class='layout' >
<div style='background-color:white'>
<center><img src='groups.jpg' width=500px height=300px></center>
</div>
<div style='background-color:#F2F2F2;'>

<font size='15' style="font-family:verdana;">Myuniworld lets you...</font>

<font size='5' style="font-family:verdana;"><ul>
<li>Organize and improve your social life
<li>Meet new people, drastically increase the size of your social network
<li>Only get to know people who see the world like you do
<li>Make new friends who are just like you
<li>Get invited to do activities with your friends, never a boring weekend
<li>We organize the activities for you, just go and have fun
<li>Huge number of fun activities to do with your friends in the Brisbane area
<li>Strengthen new and existing relationships
<li>Get to know people in your class outside of uni
<li>Start dating now, find other people at UQ to meet up with on the St Lucia Campus
<li>Go on dates with new people you've met
<li>Go on group dates, a great way to find your next boyfriend/girlfriend
<li>Stay in touch with your new and existing friends
<li>Read <a href='home_more.php'>more</a>
</ul>

<b>Sign Up  Now For A More Exciting Life</b><p>
Only for UQ students, must have a UQ email to sign up...
</font>
</div>
</div><td width=35% valign="top" height=100%>

<div class='layout' style='height:100%'>

<font size='5' style="font-family:verdana;">

<center>
<b>Sign Up</b> - It's Free
</font>

<div style='background-color:#F2F2F2;height:100%'>
<form ACTION="new_user.php" METHOD=POST>

<table>

<tr>
<td class='label'><label for="firstname">First Name</label>

<?php

if(isset($_SESSION['firstname']) == false) {
	echo "<td class='label'><input type='text' name='firstname' size='40'><br>";
} else {
	echo "<td class='label'><input type='text' name='firstname' size='40' value='" . $_SESSION['firstname'] . "'><br>";
}

?>

<tr>
<td class='label'><label for="surname">Surname</label>

<?php
if(isset($_SESSION['surname']) == false) {
	echo "<td class='label'><input type='text' name='surname' size='40'><br>";
} else {
	echo "<td class='label'><input type='text' name='surname'  size='40' value='" . $_SESSION['surname'] . "'><br>";
}

?>

<tr>
<td class='label'><label for="email">Email Address</label>

<?php
if(isset($_SESSION['email']) == false) {
	echo "<td class='label'><input type='text' name='email' size='40' value=''><br>";
} else {
	echo "<td class='label'><input type='text' name='email' size='40' value='" . $_SESSION['email'] . "'><br>";
}

?>

<tr>
<td class='label'><label for="password">Password</label>

<?php

	if(isset($_SESSION['password']) == false) {
		echo "<td class='label'><input type='password' name='password' size='40' value=''/>";
	} else {
		echo "<td class='label'><input type='password' name='password' size='40' value='" . $_SESSION['password'] . "' />";
	}

?>

<tr>
<td class='label'><label for="password1">Retype Password</label>

<?php

	if(isset($_SESSION['password']) == false) {
		echo "<td class='label'><input type='password' name='password1' size='40' value='' />";
	} else {
		echo "<td class='label'><input type='password' name='password1' size='40' value='" . $_SESSION['password'] . "' />";
	}

?>

<tr>
<td class='label'>I am
<td class='label'><select name='sex'>

<?php
if(isset($_SESSION['gender']) == false) {
	echo "<option value=2 name=2>Select Sex<option value=0 name=0>Female<option value=1 name=1>Male</select>";
} else if($_SESSION['gender'] == 1) {
	echo "<option value=1 name=1>Male<option value=0 name=0>Female";
} else {
	echo "<option value=0 name=0>Female<option value=1 name=1>Male";
}

?>

</select>

<tr><td class='label'>Date of Birth <td>
<table><tr>
<td><select name="day" size="1">

<?php

	if(isset($_SESSION['dob_day']) == false) {
		echo "<option value='x'>Day";
	} else {
		echo "<option value=" . $_SESSION['dob_day'] . ">" . $_SESSION['dob_day'];
	}

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

	if(isset($_SESSION['dob_month']) == true) { 
		echo "<option value=" . date("m", $_SESSION['dob_month']) . ">" . date( 'F', mktime(0, 0, 0, $_SESSION['dob_month']) );
	} else {
		echo "<option value='x'>Month";
	}

	for($i=1; $i<13; $i++) {
		echo "<option value=$i>" . date( 'F', mktime(0, 0, 0, $i) );
	}

?>

</select>

<td><select name="year" size="1">

<?php

	if(isset($_SESSION['dob_year']) == false) {
		echo "<option value='x'>Year";
	} else {
		echo "<option value=" . $_SESSION['dob_year'] . ">" . $_SESSION['dob_year'];
	}
	
	for($i=1970; $i<=2000; $i++) {
		echo "<option value=$i>$i";
	}

?>

</select>
</table>


<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>

</table>

<?php
if(isset($_SESSION['signup_error'])) {
	echo "<div><font color='red' size=3>" . $_SESSION['signup_error'] . "</font></div><p>";
}

?>

<input type="image" src="signup1.jpg" onmouseover='src="signup2.jpg"' onmouseout='src="signup1.jpg"' VALUE="Submit">

</form>

</center></div></div><br>

<div class='layout'><center>Why you may want to sign up...</center>

<div style='background-color:#F2F2F2;height:100%'><center><b><font size=4>Why women lose the dating game</font></b></center><P>

Think you have time to find the right guy for you, think again...<p>

<ul>
<li> &quot; The crisis for single women in this age group seeking a mate is very real. Almost one in three women aged 30 to 34 and a quarter of late-30s women do not have a partner, according to the 2006 census statistics &quot;
<li> &quot; The challenge is greatest for high-achieving women in their 30s looking for equally successful men. &quot;
<li> &quot; one in four of degree-educated women in their 30s will miss out on a man of similar age and educational achievement. &quot;
<li> &quot; Women astonished that men don't seem to be around when they decide it is time to settle down. &quot;
<li> &quot; Women labour under the impression they can have it all. They can have the career, this carefree lifestyle and then, at the snap of their fingers, because they are so fabulous, find a man. But if they wait until their 30s they're competing with women who are much younger and in various ways more attractive. &quot;
<li> &quot; So, many women are missing out on their fairytale ending - their assumption that when the time was right the dream man would be waiting.&quot;
<li> <b>Don't let this be you, sign up and start dating now to find your perfect guy on campus or risk missing out later on.</b>


</ul>

Read the full artice <a href='why-women-lose-the-dating-game.html'>here</a>

</div></div>

</table>



  </body>

</html>