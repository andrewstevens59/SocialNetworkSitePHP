<?php

$search = "";
$limit = 0;
if(isset($_REQUEST['type']) == true) {
	$type = mysql_escape_string($_REQUEST['type']);
} else {
	$type = 10;
}

if(isset($_REQUEST['user']) == true) {
	$user = mysql_escape_string($_REQUEST['user']);
} else {
	$user = $_SESSION['home_user'];
}

if(isset($_REQUEST['search'])) {
	$search = mysql_escape_string($_REQUEST['search']);
}

$tok = strtok($search, " ");
if($tok == false) {

	if ($type==0) {
		echo "<center><h1>No Results</h1></center>";
		return;
	}
	
	if($type == 5 || $type == 6 || $type == 9) {
		return;
	}
}

if(isset($_REQUEST['limit'])) {
	$limit = mysql_escape_string($_REQUEST['limit']);
	
	include('connectMySQL.php'); 
}

$count = 0;

if($type == 9) {
	// search for a product 
	$query = "select name, thumb, productid, price from product where product.productid in (select a0.userid from ";
} else if($type == 0) {
	$query = "select userid, firstname, surname, thumb, courses, degree, gender, status, interestedin from user where userid in (select a0.userid from ";
} else if($type == 10) {

	if($tok != false) {
		$query = "select user.userid, firstname, surname, thumb, courses, degree, gender, status, interestedin from user, users_online where user.userid=users_online.userid and user.userid in (select a0.userid from ";
	} else {
		$query = "select user.userid, firstname, surname, thumb, courses, degree, gender, status, interestedin from user, users_online where user.userid=users_online.userid";
	}
}  else {

	if($type == 7) {
	
		if($tok != false) {
			$query = "select user.userid, firstname, surname, thumb, courses, degree, gender, status, interestedin, count(*) from user, invites, meetups where invites.meetupid=meetups.meetupid and invites.userid=user.userid and accept!=0 and date_recorded > DATE_SUB(NOW(), INTERVAL 30 DAY) and (user.userid in (select userid2 from friends where friends.userid1=$user) or user.userid=$user) and user.userid in (select a0.userid from ";
		} else {
			$query = "select user.userid, firstname, surname, thumb, courses, degree, gender, status, interestedin, count(*) from user, invites, meetups where invites.meetupid=meetups.meetupid and invites.userid=user.userid and accept!=0 and date_recorded > DATE_SUB(NOW(), INTERVAL 30 DAY) and (user.userid in (select userid2 from friends where friends.userid1=$user) or user.userid=$user)";
		}

	} else {

		if($tok != false) {
			$query = "select userid, firstname, surname, thumb, courses, degree, gender, status, interestedin from user where (user.userid in (select userid2 from friends where friends.userid1=$user) or user.userid=$user) and user.userid in (select a0.userid from ";
		} else {
			$query = "select userid, firstname, surname, thumb, courses, degree, gender, status, interestedin from user where (user.userid in (select userid2 from friends where friends.userid1=$user) or user.userid=$user)";
		}
	
	}
}

if($tok != false) {
	while ($tok != false) {
		
		if($count == 0) {
			$query .= " permute_set a$count"; 
		} else {
			$query .= ", permute_set a$count"; 
		}
		
		$tok = strtok(" ");
		$count  = $count + 1;
	}

	$count = 0;
	$tok = strtok($search, " ");
	$query .= " where ";

	while ($tok != false) {
		
		$lower = strtolower(substr($tok, 0, min(strlen($tok), 10)));
		$query .= "a$count.match='$lower'"; 
		
		if($type == 9) {
			// restrict to products 
			$query .= " and a$count.type=8"; 
		} else if($type != 0) {
			// restrict to names only
			$query .= " and a$count.type=0"; 
		}
		
		$tok = strtok(" ");
		
		if($tok == true) {
			$query .= " and a$count.userid=a" . ($count + 1). ".userid and ";
		}
		
		$count  = $count + 1;
	}

	$query .= ")";
}

if($type == 5) {
	$query .= " and user.gender=0";
}

if($type == 6) {
	$query .= " and user.gender=1";
}

if($type == 7) {
	$query .= " group by userid order by 10 desc";
}

if($limit > 0) {
	$query .= " limit 0,$limit";
}

$result = mysql_query($query);

if($result){

	$count = 0;
	while($row = mysql_fetch_array($result)){

		if($type == 9) {
		
			echo "<div onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'show_product.php?id=" . $row ['productid'] . "'\"><table><tr>";
			echo "<td><img src='" . $row ['thumb'] . "' width=70px height=70px>";
			echo "<td>Name <b>" .$row ['name'] ."</b><br>";
			echo "Price <b>$" .$row ['price'] ."</b><br>";
			echo "</table></div>";
			
		} else if($type == 0 || $type == 10) {
		
			if($type == 0) {
				echo "<div onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"window.location = 'user_page.php?user=" . $row ['userid'] . "'\"><table><tr>";
			} else {
				echo "<div onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick=\"changeChatUser(" . $row ['userid'] . ");\"><table><tr>";
			}
			
			echo "<td><img src='" . $row ['thumb'] . "' width=70px height=70px>";
			echo "<td>Name <b>" .$row ['firstname'] . " " . $row ['surname'] ."</b><br>";
			echo "Degree <b>" .$row ['degree'] ."</b><br>";
			echo "Courses <b>" .$row ['courses'] ."</b><br>";
			/*echo "<td width=10%><td>Gender <b>";
			
			if($row['gender'] == 0) {
				echo "female";
			} else {
				echo "male";
			}
			
			echo "</b><br>";
			echo "Relationship Status <b>";
			
			if($row['status'] == 0) {
				echo "single";
			} else if($row['status'] == 1) {
				echo "in a relationship";
			} else if($row['status'] == 2) {
				echo "engaged";
			} else {
				echo "married";
			}

			echo "</b><br>";
			echo "Interested In <b>";
			
			if($row['interestedin'] == 0) {
				echo "none";
			} else if($row['interestedin'] == 1) {
				echo "men";
			} else {
				echo "women";
			}

			echo "</b><br>";*/
			echo "</table></div>";
		} else {
		
			echo "<table>";
			
			if($type != 4 && $type != 5 && $type != 6) {
				echo "<tr><td width=100% onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\"";
				
				if($type == 1) {
					echo "onclick=\"window.location = 'user_page.php?user=" . $row ['userid'] . "'\"><table><tr>";
				} else {
					echo "onclick=\"window.location = 'new_message.php?user=" . $row ['userid'] . "'\"><table><tr>";
				}
				
			} else if($type == 4) {
				echo "<tr><td width=100% onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick='reloadPage(\"invite_person.php\", \"user=" . $row['userid'] . "&id=" . $_REQUEST['meetupid'] . "\", \"show_invite.php?user=" . $_REQUEST['meetupid'] . "\", \"new_page\");return false;'><table><tr>";
			} else if($type == 5) {
				echo "<tr><td width=100% onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick='reloadPage(\"\", \"\", \"format_invite.php?id=36&dateuser2=" . $_REQUEST['dateuser2'] . "&course=" . $_REQUEST['course'] . "&date=" . $_REQUEST['date'] . "&dateuser1=" . $row['userid'] . "\", \"new_page\");return false;'><table><tr>";
			} else if($type == 6) {
				echo "<tr><td width=100% onmouseover=\"this.style.backgroundColor='#85BAD7';\" onmouseout=\"this.style.backgroundColor='#E6E6FA';\" onclick='reloadPage(\"\", \"\", \"format_invite.php?id=36&dateuser1=" . $_REQUEST['dateuser1'] . "&course=" . $_REQUEST['course'] . "&date=" . $_REQUEST['date'] . "&dateuser2=" . $row['userid'] . "\", \"new_page\");return false;'><table><tr>";
			}
			
			echo "<td><img src='" . $row ['thumb'] . "' height=70px width=70px>";
			echo "<td><b>" .$row ['firstname'] . " " . $row ['surname'] ."</b>";
			
			if($type == 7) {
				echo "<br><font color='blue'><b>" . $row[9] . " accepted invites</b></font>";
			}
			
			echo "</table><td>";
		
			if($type == 1) {
				echo "<a href='new_message.php?user=" . $row['userid'] . "'><img src='new_message1.jpg' onmouseover='this.src=\"new_message2.jpg\"' onmouseout='this.src=\"new_message1.jpg\"'></a>";
				echo "&nbsp;&nbsp;<a href='edit_friend.php?user=" . $row['userid'] . "'><img src='edit1.jpg' onmouseover='this.src=\"edit2.jpg\"' onmouseout='this.src=\"edit1.jpg\"'></a>";
			}
			
			echo "</table>";
		}
		
		$count = 1;
	}
	
	if($count == 0 && $type != 4 && $type != 5 && $type != 6) {
		echo "<center><h3>No Results</h3></center>";
	}
	

} else {
	die(mysql_error()); // useful for debug
}

if(isset($_REQUEST['limit'])) {
	$db->disconnect();
}


?>