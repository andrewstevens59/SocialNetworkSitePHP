

<?php


session_start();


include('connectMySQL.php'); 


include('banner.php');
drawBanner(false, $_SESSION['home_user']);

echo "<div class='layout'><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Individual Meetups </b></font></div><p>";


	
	
echo "<table width=92%><tr><td><div class='rounded-corners'><div style='background-color:white'><center><img src='individual_meetup.jpg'></center></div>";

echo "<div style='background-color:#F2F2F2'><font size=3>";
echo "<b>Have you met a person during a meetup that you would like to get to know better?</b>";
echo "<p><b>Have you seen boy or girl in your class that you would like to get to know?</b>";
echo "<p><b>Or maybe you just want to make a new friend </b>";
echo "<p>The only problem is you don't feel comfortable approaching the person directly, what do you do?";
echo "<hr color='black'>You send them a meetup request,";
echo "<p>Meetup requests are unique in that they allow you to see if the other person is interested in a meeting,<br> without making them aware of your own interest";
echo "<p>Only when both parties request a meetup, will a notification be sent to both sides at the same time. The <br>notification will come in the form of an ";
echo "invite, setting up a time and place for both of you to meet (on the <br>St Lucia Campus, if it is your first meetup).";
echo "<p>So you have absolutely nothing to loose by requesting a meetup. If the other person never <br>requests to meetup with you, then they will never know that you sent them one.";
echo "<p> It would be just like you never sent one, making it completely safe and secure.";
echo "<hr color='black'>To request a meetup with someone, go to their profile page and click the request meeting button</font></div><div style='background-color:white'><img src='meetup_instruct.jpg'></div>";

echo "</div></table></table>";


$db->disconnect(); // disconnect after use is a good habit


?>