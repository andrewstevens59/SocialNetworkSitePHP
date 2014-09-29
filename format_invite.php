
	<div id="big_alert" style="border: 20px outset blue ; background-color: rgb(255, 255, 255); z-index:100; top:100px; width:44%; height:300px; left:30%; display:none; background-color:#E6E6FA; overflow:auto;  position: absolute;" onmouseover='is_set=true;' onmouseout='is_set=false;'></div>

    <link rel="stylesheet" href="calendarview/stylesheets/calendarview.css">
    <style>
      body {
        font-family: Trebuchet MS;
      }
      div.calendar {
        max-width: 240px;
        margin-left: auto;
        margin-right: auto;
      }
      div.calendar table {
        width: 100%;
      }
      div.dateField {
        width: 140px;
        padding: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        color: #555;
        background-color: white;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
      }
      div#date_set:hover {
        background-color: #cde;
        cursor: pointer;
      }
    </style>
    <script src="calendarview/javascripts/prototype.js"></script>
    <script src="calendarview/javascripts/calendarview.js"></script>
    <script>
	
		var course = "";
	var date = "";
	var dateuser1 = -1;
	var dateuser2 = -1;
	
	function showActivities() {
		document.getElementById("big_alert").innerHTML = activities;
		document.getElementById("big_alert").style.display = "block";
		document.getElementById("big_alert").style.top = tempY;
		document.getElementById("big_alert").style.left = tempX - 200;
	}
	
      function setupCalendars() {


        // Popup Calendar
        Calendar.setup(
          {
            dateField: 'date_set',
            triggerElement: 'date_set'
          }
        )
      }

      Event.observe(window, 'load', function() { setupCalendars() })
	  
	  function changeActivity(id, str) {
		document.getElementById("big_alert").style.display = "none";
		document.getElementById("select_activity1").value = id;
		document.getElementById("select_activity2").innerHTML = activity_set[id];
	}
	
	function changeDate(date) {
	
		reloadPage("", "", "format_invite.php?id="+activitytypeid+"&date="+date+"&course="+course+"&dateuser1="+dateuser1+"&dateuser2="+dateuser2, "new_page");

		document.getElementById("date_div").innerHTML = date;
		document.getElementById("date_set").value = date;
	}
    </script>
  </head>
  <body>




	<?php
	
function findActivityID($activitytypeid) {

	$query = "select activity.activityid from categories, activity_category, activity where categories.type=activity_category.type and activity_category.activityid=activity.activityid and categories.activitytypeid=$activitytypeid order by activity.popularity desc";
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}

	$row = mysql_fetch_array($result);
	$activityid = $row[0];
	
	return $activityid;
}


session_start();

include('connectMySQL.php'); 

include('banner.php');

if($_REQUEST['id'] == 34) {
	// date check that your in a relationship
	$query = "select * from user a, user b where a.relid=b.userid and b.relid=a.userid and a.userid=" . $_SESSION['home_user'];
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	if(mysql_num_rows($result) == 0) {
		echo "</div><P><div class='layout'><center><b>Sorry but you have to be in mutually agreed upon relationship before you can undertake this activity. Try <a href='meetup_pool.php'>the meetup pool</a> to find your next girlfriend/boyfriend.</b></center></div>";
		echo "</table>";
		$db->disconnect();
		return;
	}
}

$activitytypeid = $_REQUEST['id'];

$query = "select image, description from activity where activityid=$activityid";
$result = mysql_query($query);

if($result == false){
	die(mysql_error());
}

$activityrow = mysql_fetch_array($result);


if(isset($_REQUEST['date']) == true) {
	
	$date = $_REQUEST['date'];
	$course = $_REQUEST['course'];
	$date_user1 = $_REQUEST['dateuser1'];
	$date_user2 = $_REQUEST['dateuser2'];
	
	include("formulate_activity.php");
	
} else {
	drawBanner(false, $_SESSION['home_user']);
	
	$date_user1 = -1;
	$date_user2 = -1;
	$course = "";
	
	include("formulate_activity.php");

	echo "<script type='text/javascript'>var activitytypeid=$activitytypeid;</script>";

	echo "<form action=\"save_formatted_invite.php?type=$activitytypeid\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<div class='layout' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Create Invite </b></font></div><p>";
	echo "<div class='layout' >";
	
	$query = "select type, image, activitytypeid, description from categories where activitytypeid=" . $_REQUEST['id'];
	$result = mysql_query($query);

	if($result == false){
		die(mysql_error());
	}
	
	$row = mysql_fetch_array($result);

	echo "<div style='background-color:#F2F2F2;'><center><img src='" . $row['image'] . "' width=150px height=150px></center><p><h2>Activity: " .  $row['type'] . "</h2><hr color='#E6E6FA'>";
	echo "<table><tr><td width=20%>";
	echo "<h2>Description</h2><font size=4>" . $row['description'] . "</font><hr color='#E6E6FA'>";

	if($activitytypeid != 37) {
		$query = "select activity.description, activity.image, activity.address, activity.activityid from categories, activity_category, activity where categories.type=activity_category.type and activity_category.activityid=activity.activityid and activitytypeid=" . $_REQUEST['id'];
	} else {
		$query = "select activity.description, activity.image, activity.address, activity.activityid from activity";
	}
	$result = mysql_query($query);

	if($result == false) {
		die(mysql_error());
	}

	echo "<h2>Choose a Venue</h2><tr><td>";

	$activity_str = "<table>";
	echo "<script type='text/javascript'>";
	echo "var activity_set = new Array();";

	if($result){

		while($row = mysql_fetch_array($result)) {
			echo "activity_set[" . $row['activityid'] . "] = \"<table " . mysql_real_escape_string($other_hover) . "><tr><td><img src='" . mysql_real_escape_string($row['image']) . "' width=70px height=70px><td><b>" . mysql_real_escape_string($row['description']) . "</b></table>\";";
			$activity_str .= "<tr><td><table $hover onclick='changeActivity(" . $row['activityid'] . ");return false;'><tr><td><img src='" . $row['image'] . "' width=70px height=70px><td width=40%><font size=4><b>" . $row['description'] . "</b></font><td><font size=4>" . $row['address'] . "</font></table>";
		}
	} else {
		die(mysql_error());
	}
	
	echo "</script>";
	$activity_str .= "</table>";
	echo "<script type='text/javascript'>activities=\"" . mysql_real_escape_string($activity_str) . "\";</script>";
	
	echo "<input type='text' style='display:none;' id='select_activity1' name='id' value='$activityid'>";
	echo "<div id='select_activity2' onclick='showActivities();return false;'><table $other_hover onclick='showActivities();return false;'><tr><td><img src='" . $activityrow['image'] . "' width=70px height=70px><td><b>" . $activityrow['description'] . "</b></table></a><p>";

	echo "<hr color='#E6E6FA'>";
	
	if($activitytypeid == 27 || $activitytypeid == 28) {
		echo "<tr><td><table><tr><td valign=middle><font size=5><b>Choose Your Course</b></font><td width=5%><td><select id='course_id' name='courses' onchange='changeCourse()'>";
		
		$query = "select course from courses where userid=" . $_SESSION['home_user'];
		$result = mysql_query($query);
		$course = "";
		
		while($row = mysql_fetch_array($result)){
			echo "<option name='" . $row['course'] . "'>" . $row['course'];
			
			if($course == "") {
				$course = $row['course'];
			}
		}
	
		echo "</select></table><hr color='#E6E6FA'>";
	}

	echo "<tr><td><h2>Choose a Date/Time</h2>";

	echo "<table><tr><td><b>Date: </b><td><input type='text' id='date_set' name='date' value='" . date("Y-m-d", $phpdate) . "' onchange='changeDate(this.value)'></table>";
	echo "<p><b>Time: </b><select name='time'>";

	echo "<option value='" . $time . "'>" . date("h:i a", strtotime($time));
	
	for($i=8; $i<24; $i++) {
		$time = $i;
		
		if($i < 13) {
			echo "<option value='" . $i . ":00'><FONT SIZE=7>$time:00 am</font>";
		} else {
			$time -= 12;
			echo "<option value='" . $i . ":00'>$time:00 pm";
		}
	}
		
	echo "</select>";

	echo "</table></font>";
	echo "</div></div><p>";
}

echo "<div id='new_page'>";

$query = "select UNIX_TIMESTAMP(date_recorded), time, activity.description, meetups.meetupid, activity.image, categories.image, type, categories.activitytypeid, invites.accept from invites, meetups, activity, categories where meetups.date_recorded like '$date' and categories.activitytypeid=meetups.activitytypeid and invites.meetupid=meetups.meetupid and meetups.activityid=activity.activityid and invites.userid=" . $_SESSION['home_user'] . " order by time asc limit 0,50";
$result = mysql_query($query);

if($result == false){
	die(mysql_error());
}

if(mysql_num_rows($result) > 0) {

	echo "<P><div class='layout'><center><font size=5><b>Your Meetups On The Same Day</b></font></center><table>";

	while($row = mysql_fetch_array($result)){
		
		echo "<tr>"; 
		echo "<td><a href='show_activity.php?id=" . $row['activitytypeid'] . "'><img src='" . $row [5] . "' height=70px width=70px></a>";
		echo "<td width=15%><b><a href='show_activity.php?id=" . $row['activitytypeid'] . "'>" . mysql_real_escape_string($row ['type']) . "</a></b>";
		echo "<td><img src='arrow.jpg' width=10px height=10px><td width=2%>";
		
		if($row['accept'] == 1) {
			echo "<td><center><img src='tick.jpg' width=30px height=30px></center>";
		} else if($row['accept'] == 2) {
			echo "<td><center><img src='maybe.jpg' width=30px height=30px></center>";
		} else {
			echo "<td><center><img src='mail.jpg' width=30px height=30px></center>";
		}
		
		echo "<td width=100% $hover onclick=\"window.location = 'show_invite.php?user=" . $row ['meetupid'] . "'\"><table><tr>";
		echo "<td><img src='" . $row [4] . "' height=70px width=70px>";
		echo "<td><b>" .$row ['description'] . "<br><font color='blue'>" . date("h:i a", strtotime($row['time']));
		echo "</b></font></table><td>";
	}

	echo "</table></div><p>";
}

echo "<div class='layout' onmouseout='dateuser1=$date_user1;dateuser2=$date_user2;'>";

if($_REQUEST['id'] == 36) {
	echo "<center><font size=5><b>Which Friends Would You Like To Set Up";
} else if($_REQUEST['id'] == 34) {
	echo "<<center><font size=5><b>You're Dating";
} else if($activitytypeid == 27 || $activitytypeid == 28) {
	echo "<center><font size=5><b>Classmates Invited";
} else if($activitytypeid == 32) {
	echo "<center><font size=5><b>Your Next Girlfriend/Boyfriend";
} else if($activitytypeid == 29) {
	echo "<center><font size=5><b>New Friends Invited";
} else {
	echo "<center><font size=5><b>Friends Invited ";
}

echo "</b></font><br>Available on the " . $date . "<br><font size=1>(and have elected to do this activity)</font></center><p>";

$friend_label = array("Acquaintances", "Talk Occassionaly", "Friends", "Would Like To Know Better", "Good Friends", "Best Friends");

$count = 0;
$total_num = 0;
$people_num = $upper_bond;
$curr_comfort = -1;
foreach($friend_set as $i) {

	if($i->comfortability != $curr_comfort) {
	
		if($curr_comfort < 0 ||  $activitytypeid != 36) {
	
			if($curr_comfort > 0) {
				echo "</table></center></div><hr color='#E6E6FA'>";
			}
			
			if($activitytypeid != 27 && $activitytypeid != 28 && $activitytypeid != 32 && $activitytypeid != 29 && $activitytypeid != 36) {
				echo "<h2>" . $friend_label[$i->comfortability] . "</h2>";
			}
			
			if($activitytypeid == 32 || $activitytypeid == 29) {
				$people_num = $upper_bond;
				if($i->gender == 1) {
					echo "<h2>Boys</h2>";
				} else {
					echo "<h2>Girls</h2>";
				}
			}
			
			$curr_comfort = $i->comfortability;
			echo "<div style='background-color:#F2F2F2;'><center><table>";
			$count = 0;
		}
	}

	if($count == 0) {
		echo "<tr>";
	}

	if($activitytypeid != 32) {
		
		if($people_num >= 0 && $i->accept_num == 0) {
			echo "<td><input type='checkbox' name='$total_num' value='$i->userid' checked>";
			$people_num--;
		} else {
			echo "<td><input type='checkbox' name='$total_num' value='$i->userid'>";
		}
	} else if($people_num > 0) {
		echo "<td><input type='checkbox' name='$total_num' value='$i->userid' checked>";
		$people_num--;
	}
	
	if($i->invite_num > 0) {
		echo "<td><table $other_hover onclick='showInvites(" . $i->userid . ");return false;'><tr>";
	} else {
		echo "<td><table><tr>";
	}
	
	if($activitytypeid != 32) {
		echo "<td><a href='user_page.php?user=" . $i->userid . "'> <img src='" . $i->thumb . "' width=70px height=70px></a><td><font size=4><a href='user_page.php?user=" . $i->userid . "'><b>" . $i->firstname . " " . $i->surname . "</b></a></font><br>";
	} else if($people_num >= 0)  {
		echo "<td><img src='activities/question_mark.jpg' width=70px height=70px><td><font size=4><b>" . $i->firstname . ", ";
		
		$prev_date = date("Y-m-d", $i->dob);
		$datetime1 = new DateTime($prev_date);
		$datetime2 = new DateTime();
		$interval = $datetime1->diff($datetime2);
			
		echo $interval->y . "</b></font> <br>";
			
		calculateMatch($user_row[0], $i->questions, 1);
		echo "</font><br>";
	}
	
	if($activitytypeid != 32 || $people_num >= 0) {
		if($i->invite_num > 0) {
			echo "<font color='blue' size='1'>" . $i->invite_num . " pending invites</font><br>";
		}
		
		if($i->accept_num > 0) {
			echo "<font color='red' size='1'>" . $i->accept_num . " invite(s) accepted</font><br>";
		}
		
		$count = $count + 1;
		if($count >= 3) {
			$count = 0;
		}
	}
	
	echo "</table><td width=3%>";
	
	$total_num++;
	if($people_num == 0) {
		$people_num = -1;
	}
}


if($activitytypeid == 36) {

	if($total_num  > 0) {
		echo "</table></center></div>";
	}

	// date set up
	echo "<center><table><tr>";
	
	?>
	<td><font size=4><b>Girl</b></font>
	<td align="right"><input type="text" style="height: 35px;font-size:20px;" name="search1" size="20" onkeyup="showSearchRes('friends_page1', this.value, 5, 5, ' <?php echo "&dateuser2=$date_user2&course=$course&date=$date');"; ?>  ">
	<?php
	
	echo "<td width=10%>";
	
	?>
	<td><font size=4><b>Boy</b></font>
	<td align="right"><input type="text" style="height: 35px;font-size:20px;" name="search2" size="20" onkeyup="showSearchRes('friends_page2', this.value, 6, 5, ' <?php echo "&dateuser1=$date_user1&course=$course&date=$date');"; ?> ">
	<tr><td colspan="2"><div id="friends_page1"></div><td width=10%><td colspan="2"><div id="friends_page2"></div></table></center>
	<?php
	
	if($date_user1 == -1 || $date_user2 == -1) {
		echo "</div><P><div class='layout'><center><b>You must select two people to go on the date first</b></center></div></div>";
		echo "</table>";
		$db->disconnect();
		return;
	}
} else if($total_num > 0) {
	echo "</table></center></div>";
}

echo "<input type='text' style='display:none;' value='$total_num' name='total_invites'>";
echo "</div>";

if($total_num == 0) {
	echo "</div><P><div class='layout'><center>You currently don't have any friends that want to do this activity.<br><b>Persuade more of your friends to join to do this activity with them.</b></center></div>";
	echo "</table>";
	$db->disconnect();
	return;
}


$query = "select UNIX_TIMESTAMP(timestamp) from last_n_activities where userid=" . $_SESSION['home_user'] . " and activitytypeid=" . $_REQUEST['id'] . " order by timestamp desc limit 1";
$result = mysql_query($query);

if($result == false) {
	die(mysql_error());
}

$row = mysql_fetch_array($result);

$unixNowDate = strtotime('now');
$difference = $unixNowDate - $row[0];
$days = (int)($difference / 86400);


if( $days  < 2) {
	echo "</div><P><div class='layout'><center><b>Cannot Request This Activity For Another " . (2 - $interval) . " days</b></center></div>";
	echo "</table>";
	$db->disconnect();
	return;
}

echo "<p><div class='layout'><center><input type=\"image\" VALUE=\"Submit\" src='generate_invite1.jpg' onmouseover='this.src=\"generate_invite2.jpg\"' onmouseout='this.src=\"generate_invite1.jpg\"'></div></form>";

?>


</div>
</table>

<?php

$db->disconnect(); // disconnect after use is a good habit

?>

</div>
