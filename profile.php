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
	


	textarea {  
	  font-family: inherit;
	  font-size: inherit;
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


<div style="background-image:url('banner.jpg'); width:100%;  height:73px; background-repeat: no-repeat;"> </div>
<center>
<div style="background-color:#E6E6FA">
<font size='6'><b>Create Your Profile</b></font><p>
<div style='background-color:#F2F2F2;'>
<form action="upload.php" method="post"
enctype="multipart/form-data">

<table>

<tr>
<td class='label'><label for="image">Profile Image</label>
<td class='label'><input type="file" name="image"></td></tr>


<tr>
<td class='label'><label for="description">About Me Description</label>
<td class='label'><textarea name="description" cols="45" rows="3"></textarea><br>

<tr>
<td class='label'><label for="interestedin">Interested In</label>
<td class='label'><select name="interestedin" size="1">

<?php

session_start();

if($_SESSION['gender'] == 1) {
	echo "<option value=2>Women<option value=1>Men<option value=0>None";
} else {
	echo "<option value=1>Men<option value=2>Women<option value=0>None";
}

?>

</select>

<tr>
<td class='label'><label for="status">Relationship Status</label>
<td class='label'><select name="status" size="1">
<option value=0>Single
<option value=1>In a relationship
<option value=2>Engaged
<option value=3>Married
<option value=4>In an open relationship
</select>

<tr>
<td class='label'><label for="degree">Degree</label>
<td class='label'><input type="text" name="degree" size=40>

<tr>
<td class='label'><label for="university">University</label>
<td class='label'><input type="text" name="university" size=40 value="University of Queensland">

<tr>
<td class='label'><label for="employers">Employers</label>
<td class='label'><input type="text" name="employers" size=40>

<tr>
<td class='label'><label for="highschool">High School</label>
<td class='label'><input type="text" name="highschool" size=40>

<tr>
<td class='label'><label for="courses">Enrolled Courses<br><i>(Course Code Only)</i></label>
<td class='label'><input type="text" name="courses" size=40>
<tr>
<td class='label'><label for="postcode">Postcode <i>(Kept Private)</i></label>
<td class='label'><input type="text" name="postcode" size=4 maxlength=4>

<tr>
<td class='label'><label for="ethnicity">Ethnicity</label>
<td class='label'><select name="ethnicity" size="1">

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

<tr>
<td><input type='checkbox' name='entrepreneur'>
<td class='label'>I have an idea for a company I would like to pursue

<tr><td colspan="2">
<hr color="#E6E6FA">
<b>Fill out your personality profile. This information is kept private. It's only used to help you find other people like you</center><p>
<div class='layout' style='overflow: auto;height:300px;'>
<table>
<tr>
<td>

<?php


$qs[0] = "I have a tendency to be serious about things at times";
$qs[1] = "I have a tendency to be quiet at times";
$qs[2] = "I am able to concentrate on problems for a very long period of time";
$qs[3] = "I&#39;m always well organized";
$qs[4] = "I&#39;m hard working, I always prioritize work over fun";
$qs[5] = "I work steadily towards goals I have identified for myself";
$qs[6] = "I&#39;m always conscientious and kind";
$qs[7] = "I&#39;m sensitive and kind ";
$qs[8] = "I avoid conflict";
$qs[9] = "I like to help others";
$qs[10] = "I&#39;m loyal and faithful to others above all else";
$qs[11] = "I like to lead in all situations";
$qs[12] = "I&#39;m a creative thinker and enjoy creative problem solving";
$qs[13] = "I&#39;m very practical and traditional";
$qs[14] = "I&#39;m very people orientated and fun loving";
$qs[15] = "I&#39;m willing to bend the rules if they are not applicable in all situations";
$qs[16] = "I&#39;m assertive and outspoken, loudest person in the room";
$qs[17] = "I&#39;m very resourceful, know how to get the most out of people";
$qs[18] = "I&#39;m very popular and fun to be around";
$qs[19] = "I&#39;m an idealist and stick to what I think is right in all situations";
$qs[20] = "I&#39;m very adaptable and laid back";
$qs[21] = "I&#39;m very action orientated";
$qs[22] = "I&#39;m a logical thinker in my decision making process";
$qs[23] = "I&#39;m very analytical";
$qs[24] = "I&#39;m very independent, not concerned about what other people are doing";
$qs[25] = "I&#39;m happy with my life right now and don&#39;t think a lot about the future";
$qs[26] = "I&#39;m a risk taker";
$qs[27] = "I&#39;m a long-range thinker; I know what I&#39;m going to be doing in the next 10 years";
$qs[28] = "I have a fast-paced lifestyle";
$qs[29] = "I get excited by new theories and ideas";
$qs[30] = "I&#39;m sometimes become bored with long explanations or excessive detail";
$qs[31] = "I&#39;m all about living the here and now";
$qs[32] = "I&#39;m good at organizing myself and others";
$qs[33] = "I value knowledge highly";
$qs[34] = "I have little interest in theory or abstraction";
$qs[35] = "I often want immediate results even if they are not optimal";
$qs[36] = "I have a clear vision of the way things should be";
$qs[37] = "I value security and peaceful living";
$qs[38] = "I love new experiences all the time";
$qs[39] = "I like to be the centre of attention in social situations";
$qs[40] = "I feel a strong sense of responsibility and duty";
$qs[41] = "I need to live life in accordance with my inner values";
$qs[42] = "I&#39;m open-minded and flexible";
$qs[43] = "I excel at public speaking";
$qs[44] = "I have little patience for inefficiency or disorganization";
$qs[45] = "I&#39;m good at a broad range of things";
$qs[46] = "I find it difficult to stick to a routine";
$qs[47] = "I often get invited to places because I&#39;m fun to be around";
$qs[48] = "I require no interaction with others to feel good about myself";
$qs[49] = "I have a good intuition about others and interested in understanding them";
$qs[50] = "I like to be individualistic rather than leading or following";
$qs[51] = "I have a tendency to be detached at times";
$qs[52] = "I like to spend time on activities that I design myself";
$qs[53] = "I like to find solutions to practical problems over that of theoretical ones";
$qs[54] = "I can easily apply abstract theories to real life applications";
$qs[55] = "I&#39;m difficult to get to know well";



for($i=0; $i<55; $i++) {

	echo "<tr><td>";

	echo $qs[$i];
	echo "<hr color='white'>";
	echo "<td><input type='radio' name='q$i' value=1 /><td> Yes";
	echo "<td><input type='radio' name='q$i' value=0 /><td> No";
}


?>

</table></div>
<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td><input type="image" src="login1.jpg" onmouseover='src="login2.jpg"' onmouseout='src="login1.jpg"' VALUE="Submit">

</table>
</fieldset>
</form>
</div>
</center>


  </body>

</html>