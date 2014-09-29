<div id='new_page'>

<style>

/* calendar */
table.calendar    { border-left:1px solid #999; }
tr.calendar-row  {  }
td.calendar-day  { min-height:80px; font-size:11px; position:relative; background:#FAF8CC; } * html div.calendar-day { height:80px; }
td.calendar-day:hover  { background:#FAF8A0; }
td.calendar-day-np  { background:#E1FFD7; min-height:80px; } * html div.calendar-day-np { height:80px; }
td.calendar-day-head { background:#B4CFEC; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
div.day-number    { background:#999; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
div.day-select   { background:red; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
/* shared */
td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }

</style>

<script type="text/javascript">

var dates = new Array();

function showAlertTemp(id) {

	document.getElementById("alert1").innerHTML = dates[id];
	document.getElementById("alert1").style.display="block";
	document.getElementById("alert1").style.top = tempY;
	document.getElementById("alert1").style.left = tempX - 200;
}

function changePage(user, id) {
	window.location = 'show_invite.php?user=' + id + "&id=" + user;
}

function changeOver(ptr) {
	ptr.style.backgroundColor = '#85BAD7';
}

function changeOut(ptr) {
	ptr.style.backgroundColor = '#E6E6FA';
}

</script>

<?php

$dates = array();

/* draws a calendar */
function draw_calendar($month,$year, $dates){

  /* draw table */
  $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

  /* table headings */
  $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
  $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

  /* days and weeks vars now ... */
  $running_day = date('w',mktime(0,0,0,$month,1,$year));
  $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  $days_in_this_week = 1;
  $day_counter = 0;
  $dates_array = array();

  /* row for week one */
  $calendar.= '<tr class="calendar-row">';

  /* print "blank" days until the first of the current week */
  for($x = 0; $x < $running_day; $x++):
    $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    $days_in_this_week++;
  endfor;

  /* keep going with days.... */
  for($list_day = 1; $list_day <= $days_in_month; $list_day++):
  
	  $current_day = '<td class="calendar-day"';
	  if($year == date("Y") && $month == date("m") && $list_day == date("d")) {
		$current_day = '<td class="calendar-day" style="background-color:#A9A9F5;"';
	  }
    
	  if($dates[$list_day] != "") {
		$calendar.= $current_day . ' onclick="showAlertTemp(' . $list_day . ');">';
		$calendar.= '<div class="day-select">'.$list_day.'</div>';
	  } else {
		$calendar.= $current_day . '>';
		$calendar.= '<div class="day-number">'.$list_day.'</div>';
	  }
	  
      $calendar.= str_repeat('<p>&nbsp;</p>',2);
      
    $calendar.= '</td>';
    if($running_day == 6):
      $calendar.= '</tr>';
      if(($day_counter+1) != $days_in_month):
        $calendar.= '<tr class="calendar-row">';
      endif;
      $running_day = -1;
      $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
  endfor;

  /* finish the rest of the days in the week */
  if($days_in_this_week < 8):
    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
      $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
    endfor;
  endif;

  /* final row */
  $calendar.= '</tr>';

  /* end the table */
  $calendar.= '</table>';
  
  /* all done, return result */
  return $calendar;
}


session_start();


include('connectMySQL.php'); 

$userid = $_SESSION['home_user'];
if(isset($_REQUEST['user'])) {
	$userid = $_REQUEST['user'];
}


$skip = 0;
if(isset($_REQUEST['date']) == true) {
	$skip = $_REQUEST['date'];
}

$curr_mth  = date("m", mktime(0, 0, 0, date("m")+$skip, 1, date("Y")));

$query = "update alerts set alerts.meetings=0 where userid=$userid";
$temp = mysql_query($query);

include('banner.php');
drawBanner(false, $userid);

include('check_privacy.php');
checkAccessRights($userid, "meetups");


$temp_str = "";
echo "<script type=\"text/javascript\">";

$dates = array();

echo "function loadDates() {";

for($i=0; $i<32; $i++) {
	echo " dates[" . $i . "] = \"\";";
	$dates[$i] = "";
}


for($new = 1; $new >= 0; $new--) {

	if($new == 1) {
		$is_new = "invites.timestamp > '" . $_SESSION['last_login'] . "'";
	} else {
		$is_new = "invites.timestamp <= '" . $_SESSION['last_login'] . "'";
	}

	$query = "select UNIX_TIMESTAMP(date_recorded), time, activity.description, meetups.meetupid, activity.image, categories.image, type, categories.activitytypeid, invites.accept from invites, meetups, activity, categories where $is_new and categories.activitytypeid=meetups.activitytypeid and invites.meetupid=meetups.meetupid and meetups.activityid=activity.activityid and invites.userid=$userid order by date_recorded asc limit 0,50";
	$result = mysql_query($query);

	if($result == false){
		die(mysql_error());
	}

	if(mysql_num_rows($result) > 0) {

		if($new == 0) {
			$temp_str .= "<P><div class='layout'>";
		} else {
			$temp_str .= "<P><div class='layout' style='border: 2px solid red'>";
		}
		
		$temp_str .= "<table>";
		$today = strtotime(date("Y-m-d")); 
		
		while($row = mysql_fetch_array($result)){
		

			$tmp = date("Y-m-d", $row[0]);
			$date = strtotime($tmp . " +1 days");
			$expiration_date = strtotime(date("Y-m-d", $date));
			
			if($expiration_date >= $today && ($new == 1 || $row['accept'] != 0) && $userid == $_SESSION['home_user']) {
				$temp_str .= "<tr>"; 
				
				$temp_str .= "<td><a href='show_activity.php?id=" . $row['activitytypeid'] . "'><img src='" . $row [5] . "' height=70px width=70px></a>";
				$temp_str .= "<td width=15%><b><a href='show_activity.php?id=" . $row['activitytypeid'] . "'>" . mysql_real_escape_string($row ['type']) . "</a></b>";
				$temp_str .= "<td><img src='arrow.jpg' width=10px height=10px><td width=2%>";
				
				if($row['accept'] == 1) {
					$temp_str .= "<td><center><img src='tick.jpg' width=30px height=30px></center>";
				} else if($row['accept'] == 2) {
					$temp_str .= "<td><center><img src='maybe.jpg' width=30px height=30px></center>";
				} else if($new == 1) {
					$temp_str .= "<td><center><img src='mail.jpg' width=30px height=30px></center>";
				}
				
				$temp_str .= "<td width=100% $hover onclick=\"window.location = 'show_invite.php?user=" . $row ['meetupid'] . "'\"><table><tr>";
				$temp_str .= "<td><img src='" . $row [4] . "' height=70px width=70px>";
				$temp_str .= "<td><b>" .$row ['description'] . "<br><font color='blue'>" . date("h:i a", strtotime($row['time'])) . " " . date("(l dS \of F Y)", strtotime($tmp . " +1 days"));
				$temp_str .= "</font></b></table><td>";
			}
				
			if(date("Y",$date) == date("Y") && date("m",$date) == $curr_mth) {

				$str = "'<div onmouseover=\"changeOver(this);\" onmouseout=\"changeOut(this);\" onclick=\"changePage($userid, " . $row ['meetupid'] . ");\"><table><tr><td><img src=\"" . $row [4] . "\" height=70px width=70px>";
				$str .= "<td><b>" . mysql_real_escape_string($row ['description']) . "<br><font color=blue>Time " . date("h:i a", strtotime($row['time'])) ."</font></b><td width=3%>";
				
				if($row['accept'] == 1) {
					$str .= mysql_real_escape_string("<td><center><img src='tick.jpg' width=30px height=30px></center>");
				} else if($row['accept'] == 2) {
					$str .= mysql_real_escape_string("<td><center><img src='maybe.jpg' width=30px height=30px></center>");
				} else {
					$str .= mysql_real_escape_string("<td><center><img src='mail.jpg' width=30px height=30px></center>");
				}
				
				$str .= "</table></div>'";

				echo "dates[" . date("d",$date) . "] += " . $str . "; ";
				$dates[intval(date("d",$date))] .= $str;
			}
		}

		$temp_str .= "</table></div>";
	}

}

echo "}";

echo "loadDates()";
echo " </script>";

$temp_str .= "</table>";

$query = "select firstname, surname from user where userid=$userid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$username = $row['firstname'] . " " . $row['surname'];

echo "<div class='layout'><b><font size=6> $username <img src='arrow.jpg' width=20px height=20px> Meetups</b></font></div><p>";

echo "<div class='layout'><center>";

echo "<center><font size=6><b>" . date("M Y", mktime(0, 0, 0, date("m")+$skip, 1, date("Y"))) . "</b></font></h2></center><p>";

echo "<a href='meetups.php?user=$userid&date=" . ($skip-1) . "'><img src='prev_month1.jpg' onmouseover=\"this.src='prev_month2.jpg'\" onmouseout=\"this.src='prev_month1.jpg'\"></a>&nbsp;&nbsp;<a href='meetups.php?user=$userid&date=" . ($skip+1) . "'><img src='next_month1.jpg' onmouseover=\"this.src='next_month2.jpg'\" onmouseout=\"this.src='next_month1.jpg'\"></a><p>";

echo draw_calendar($curr_mth, date("Y"), $dates);

echo "</center></div>";

if($userid == $_SESSION['home_user']) {
	echo $temp_str;
}

$db->disconnect(); // disconnect after use is a good habit

?>

</div>