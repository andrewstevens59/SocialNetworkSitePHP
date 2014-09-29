<?php


session_start();
include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

echo "<div class='layout'><font size=6><b><center>People Online</center></b></font></div><p>";

echo "<div class='layout'>";
	
	echo "<center><table><tr>";
	echo "<form ACTION=\"search.php?type=1\" METHOD=POST autocomplete=\"off\">";
	
	?>
	<td valign=middle><input type="text" style="height: 35px;font-size:20px;" name="search" size="80" onkeyup="showSearchRes('friends_page', this.value, 10, 10);"></td>
	<td valign=middle><input type="image" VALUE="Search" src='search1.jpg' onmouseover='this.src="search2.jpg"' onmouseout='this.src="search1.jpg"'></td>

	</form></table></center></div><p><div class='layout' id='friends_page'>
	


<?php

include('search_results.php');
echo "</div>";

$db->disconnect(); // disconnect after use is a good habit


?>