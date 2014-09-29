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

  <body>


<div style="width:100%;background-color:blue">sdfsfasdfdasf</div>

<form ACTION="new_user.php" METHOD=POST>

<table>

<tr>
<td><label for="firstname">First Name</label>
<td><input type="text" name="firstname" id="firstname" size="20"><br>

<tr>
<td><label for="surname">Surname</label>
<td><input type="text" name="surname" id="surname" size="20"><br>

<tr>
<td><input type="radio" name="sex" value="male" id="sex" CHECKED>Male<br>
<td><input type="radio" name="sex" value="female" id="sex">Female<br>

<tr>
<td><label for="email">Email Address</label>
<td><input type="text" name="email" id="email" size="20"><br>

<tr>
<td><label for="password">Password</label>
<td><input type="password" name="password" id="password" size="20" /><br />

<tr>
<td><label for="password1">Retype Password</label>
<td><input type="password" name="password1" id="password1" size="20" /><br />

<td><input type="submit" VALUE="Submit">

</table>
</form>

<?php


session_start();

echo $_SESSION['error'];

?>

  </body>

</html>
