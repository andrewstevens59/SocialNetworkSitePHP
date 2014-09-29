

<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>

<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />


<?php

	function printLikeLink($id, $type, $userid1, $userid2, $wallid, $page_type) {

		$query = "select * from $type where id=$id";
		$tmp1 = mysql_query($query);
		
		if(mysql_num_rows($tmp1) > 0) {
			echo "<a href='' onclick='return showLikes($id, \"$type\")'>(+" . mysql_num_rows($tmp1) . ")</a>&nbsp;";
		}
		
		$query = "select * from $type where id=$id and userid=" . $_SESSION['home_user'];
		$tmp1 = mysql_query($query);
		
		if(mysql_num_rows($tmp1) == 0) {
			echo "<a href='' onclick='reloadPage(\"$type.php\", \"id=$id&user1=$userid1&user2=$userid2&wallid=$wallid\", \"$page_type\", \"new_page\");return false;'>Like</a>";
		} else {
			echo "<b>you like this</b>";
		}
	}
	
	function getWallPosting($query, $userid, $title, $page_type) {

		$tmp = "select firstname, surname from user where userid=$userid";
		$result = mysql_query($tmp);
		$row = mysql_fetch_array($result);
		$username = $row['firstname'] . " " . $row['surname'];

		echo "<div class='layout' ><b><font size=6>$username <img src='arrow.jpg' width=20px height=20px> $title</b></font></div><p>";
		
		$result = mysql_query($query);
		$count = 0;
		
		$res_str = "";

		if($result){
		

			if($title != "Wall Post") {
				echo "<div class='layout' ><center><form ACTION=\"post_wall.php?user=$userid&name=Wall+Post\" METHOD=\"post\" enctype=\"multipart/form-data\"><table><tr>";
				echo "<td><img src='" . $_SESSION['micro_image'] . "' width=70px height=70px>";
				echo "<td><table><tr><td><textarea name=\"message\" rows=1 cols=60 onkeyup=\"resizeTextarea(this)\" onmouseup=\"resizeTextarea(this)\"></textarea><td><input type=\"image\" VALUE=\"Submit\" src='post1.jpg'  onmouseover='this.src=\"post2.jpg\"' onmouseout='this.src=\"post1.jpg\"'>";
				

				if($page_type == 'broadcast.php') {
					echo "<tr><td><table><tr><td><input type=\"file\" name=\"image\"><td width=2%><td><b>Hide My Identity</b><td><input type='checkbox' name='hide'></table>";
				} else {
					echo "<tr><td colspan=\"2\"><input type=\"file\" name=\"image\">";
				}
				
				
				echo "</table></table></form></center></div><br>";
			}
			
			echo "<div class='layout'>";

			while($row = mysql_fetch_array($result)){
				echo "<div style='background-color:#F2F2F2;'><div style='width:70%;'><table width=100%><tr>";
				
				if($row['privacy'] == 0) {
					echo "<td width=0%><a href='user_page.php?user=". $row['userid'] . "'><img src='" . $row ['thumb'] . "' width=70px height=70px>";
					echo "<td width=100%><table><tr><td><b><a href='user_page.php?user=" . $row['userid'] . "'>" .$row ['firstname'] . " " . $row ['surname'] ."</a></b>&nbsp;&nbsp;" . $row ['message'];
				} else {
					echo "<td><table><tr><td><img src=\"activities/question_mark.jpg\" width=70px height=70px><td>" . $row ['message'] . "</table>";
				}
				
				echo "<tr><td><tr><td><tr><td>";
				if($row ['photo'] == "") {
					echo "<font size=2 color='#0404B4'>";
					printLikeLink($row['wallid'], 'wall_post_like', $row['userid'], -1, $row['wallid'], $page_type);
					echo "&nbsp;&nbsp;<a href='' onclick='return comment(\"$count\", " . $row['userid'] . ", -1)'>Comment</a></font></div><br>";
				}
				echo "</table><td valign=middle width=0%>";
				
				if($row['userid'] == $_SESSION['home_user']) {
					echo "<a href='delete_wall_post.php?id=" . $row['wallid'] . "'><img src='cross.jpg' width=7px height=7px></a>";
				}
				
				echo "</table>";
				
				if($row ['photo'] != "") {
					echo "<table algin=left><tr><td width=5%><td><table><tr><td><a href='photos.php?name=Wall+Post&user=" . $row['userid'] . "'><img src='" . $row ['photo'] . "' width=300px height=300px></a>";
					echo "<tr><td><font size=2 color='#0404B4'>";
					printLikeLink($row['wallid'], 'wall_post_like', $row['userid'], -1, $row['wallid'], $page_type);
					echo "&nbsp;&nbsp;<a href='' onclick='return comment(\"$count\", " . $row['userid'] . ", -1)'>Comment</a></font></table></table>";
				}
				
				$query = "select user.userid, wall_comment.commentid, comment, thumb, firstname, surname, timestamp from wall_comment, user where user.userid=wall_comment.userid and wall_comment.wallid=" . $row['wallid'] . " order by wall_comment.timestamp asc";
				$tmp = mysql_query($query);
				
				if($tmp == false) {
					die(mysql_error());
				}

				if(mysql_num_rows($tmp) > 0) {
					echo "<table><tr><td width=10%><div style='background-color:#E0E0F8;width:90%;'>";
				}
				
				while($row1 = mysql_fetch_array($tmp)){
				

					echo "<table><tr><td><a href='user_page.php?user=" . $row1['userid'] . "'><img src='" . $row1['thumb'] . "' width=45px height=45px></a><td><table><tr><td><a href='user_page.php?user=" . $row1['userid'] . "'>" . $row1['firstname'] . " " . $row1['surname'] . "</a>&nbsp;&nbsp;" .  $row1['comment'] . "<tr valign=top><td><div class='comments'><font size=1 color='#0404B4'>";
					
					printLikeLink($row1['commentid'], 'wall_comment_like', $row['userid'], $row1['userid'], $row['wallid'], $page_type);
					
					echo "&nbsp;&nbsp;<a href='' onclick='return comment(\"$count\", ". $row['userid'] . "," . $row1['userid'] . ")'>Comment</a></font></div></table></table><hr color='#E6E6FA'>";
				}
				
				if(mysql_num_rows($tmp) > 0) {
					echo "</div></table>";
				}
				
				echo "<table algin=left><tr><td width=5%><td><table><tr><td>";
				echo "<tr><td><div style='display:none;' id='$count'>";
				echo "<table><tr><td><img src='" . $_SESSION['micro_image'] . "' width=45px height=45px><td><textarea id='comment_message$count' name=\"comment\" rows=1 cols=60 onkeyup=\"resizeTextarea(this)\" onmouseup=\"resizeTextarea(this)\"></textarea><td><input type=\"image\" VALUE=\"button\" src='post1.jpg' onclick='reloadPage(\"post_wall_comment.php\", \"wallid=" . $row['wallid'] . "&user1=\" + curr_user1 + \"&user2=\" + curr_user2 + \"&comment=\" + document.getElementById(\"comment_message$count\").value, \"$page_type\", \"new_page\");return false;' onmouseover='this.src=\"post2.jpg\"' onmouseout='this.src=\"post1.jpg\"'></table></div>";
				echo "</table></div></table>";
				
				echo "</div><div><hr color='#E6E6FA'>";
				$count = $count + 1;
			}
			
			echo "</div></table>";

		} else {
			die(mysql_error()); // useful for debug
		}
		
	}
	
?>