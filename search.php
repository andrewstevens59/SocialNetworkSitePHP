<?php


session_start();
include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

echo "<div class='layout'><font size=6><b><center>Search Results</center></b></font></div><p>";

echo "<div class='layout'>";
include('search_results.php');
echo "</div>";

$db->disconnect(); // disconnect after use is a good habit


?>