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
		 text-align: center; /* !!! */
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

.centered {
    margin: 0 auto;
    text-align: left;
    width: 800px;
}
	
	
	</style>
	
  <body>


<div style="background-image:url('banner.jpg'); width:100%;  height:70px; background-repeat: no-repeat;">

<form ACTION="login.php" METHOD=POST>

<table width=100%>


<tr>

<td width=70%><td><table><tr><td>

<td><font color='white'>Email Address</font><td><font color='white'>Password</font><td>
<tr><td>

<?php


session_start();

if(isset($_SESSION['error'])) {
	echo "<div style='width:150px'><font color='red' size='5'>" . $_SESSION['error'] . "</font></div>";
}

if(isset($_SESSION['email1']) == false) {
	echo "<td class='label'><input type='text' name='email' size='20' value='' style='height:25px'><br>";
} else {
	echo "<td class='label'><input type='text' name='email' size='20' value='" . $_SESSION['email1'] . "' style='height:25px'><br>";
}

if(isset($_SESSION['password1']) == false) {
	echo "<td class='label'><input type='password' name='password' size='20' value='' style='height:25px' />";
} else {
	echo "<td class='label'><input type='password' name='password' size='20' value='" . $_SESSION['password1'] . "' style='height:25px' />";
}

?>

<td><input type="image" src='login1.jpg' VALUE="Submit" onmouseover="this.src='login2.jpg'" onmouseout="this.src='login1.jpg'">
</table>

</table>
</form>
</center>
</div>

<div style="background-color:#E6E6FA">
<center>
<font size='6'><b>How Meetup Can Help You</b></font><p></center>
<div class="centered" style='background-color:#F2F2F2;width:50%;align:center;'><font size='4'>

<center><h2>General Friendships</h2></center>
As most students make the transition from high school to university they encounter a very different environment to what they are probably familiar with. Many students choose to stay in touch with their friends from high school as they can find it difficult to meet new people or get to know people outside of a university environment. In addition many students have a large number of friends on Facebook and other social networking sites that they rarely see or don&#39;t see at all. It can be very time consuming and difficult to organize activities to do with your friends and it&#39;s usually left up to one person to take on the responsibility to arrange a large group of people to meet. <P>
From a psychological standpoint it&#39;s necessary and important for your wellbeing to maintain at least some relationships/ friendships as part of your daily life. It&#39;s also necessary to see your friends on a regular basis to maintain and strengthen existing relationships. Part of the problem with this however is that people generally don&#39;t feel comfortable making arrangements to see their friends unless they know them very well or are part of a larger group where there are multiple people to interact with. <P>
Meetup can help you to overcome these problems by automatically scheduling activities to do with your existing friends, some you see often and some you see only occasionally. Meetup also allows you to assign preferences to your friends, so you can see your good friends more often. No one person is responsible for organizing the activity but instead is left up to Meetup to arrange a set of invites for a group of your friends to meet up in groups on regular occasions. This is your chance to see your long lost friends from high school or new people you&#39;ve only just met at university that you would like to get to know better. Most importantly you may often be invited to attend activities not only with friends in your immediate circle but some new potential friends of a friend an existing friend. <P>
You also have the opportunity to do activities you wouldn&#39;t normally do, go out more often to more exciting places and meet some new and interesting people with the support of your existing friends in close company. By signing up to Meetup we can help you open a doorway to a more exciting and adventurous life than you would otherwise experience. The more friends you have on Meetup the more activities you can do outside of university. There are also a large number of activities designed to allow you to meet new people. There are class activities designed to be done outside of university for every course you are enrolled in. Class meetups allow you to get to know the people you see every day in your course outside of a university environment and help you to forge new friendships. There are also activities designed to allow you to meet new people you wouldn&#39;t ordinarily come into contact with. <P>

<center><h2>Dating</h2></center>
A large part of social interaction of course is geared towards casual dating or finding your next boyfriend/girlfriend. If you come from an area of study that is primarily dominated by one gender this can be a very challenging task. Also if you don&#39;t have many friends in your immediate social network of the opposite gender it can also be challenging to forge a potential relationship. If you&#39;ve ever tried to find a suitable long term relationship by <b>going to bars, clubs, dating sites etc</b>, you may soon realize that you are simply <b>wasting your time</b>. The majority of males that you find at these places have no interest in a long term relationship. So your attention turns to university life. <P>
You come into contact everyday with other tertiary qualified candidates similar to you in a lot of ways who would be able to offer you a great deal now and in the future. The only problem is that usual academic interaction is not typically targeted towards dating or takes far too long to build a friendship until it does. Meetup is unique in that it allows you to request one on one meetups with people you&#39;re interested in forming relationships with. These kinds of individual meetups are only arranged on the St. Lucia Campus allowing you to spend some alone time with the person getting to know them a little better. Better still meetups can be arranged in complete secrecy. Only when both individuals have requested a meetup of one another will a time and place on campus be arranged for you both to meet. There is no need to confront the person directly; if you request a meetup and the other person never does, then they will not know that you did, making it safe and secure. <P>
So if there is a boy or girl in your class that you are interested in, try sending them a meetup request. You can also search for other individuals on campus to meetup with, that you think you would be compatible with.  Meetup provides you with a compatibility match score to help you find other people just like you. If you find someone you like send them a meetup request and see what happens, engineering department may I introduce you to the psychology department. You can also go on group dates outside of university as well as setting up your friends or yourself on dates. Best of all they will never know that you arranged the date if you set yourself up. A date will only be organized when both have accepted the date again in a similar secret fashion, so the other side will not know that you accepted that date when they didn&#39;t. <P>

<center><h2>Why You Need To Start Dating Now...</h2></center>
It&#39;s very important for you to start dating now as you will find it increasingly difficult to meet suitable people as you age and enter the workforce, remember the world is a very different place outside of university, you have a signficantly better chance of finding a suitable partner at university than anywhere else. Remember where else are you going to find people from a similar level of tertiary education, similar goals/motivations/desires in life, similar income level, the list goes on and on. <p>The problem is especially true for women as male attention quickly dissipates as you age, sorry but it&#39;s an evolutionary fact. If you're female and you decide to wait, you may quickly realize the there simply aren't any good men your age. The ones that are available, have quickly set their sights on the younger more attractive females, who are ready for a relationship now. Meetup can help you to avoid the 25 age crunch, by building up your social network sooner rather than later. What other site lets you strengthen new and existing relationships with actual social interaction. 
Watch as your number of friends grows giving you a much greater selection of candidates for a present or future relationship. You can still live the fairytale ending, it does exist if you're clever about your approach. So have some fun meeting new people strengthen existing relationships go out more and see what happens, your life may take an unexpected turn for the better... <P>
<center><h2>So sign up now for a more fun and exciting life</h2></center>


 

</font>
</div>

</div>



  </body>

</html>