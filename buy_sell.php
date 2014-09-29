<div id='new_page'>

<?php


session_start();


include('connectMySQL.php'); 

$userid = $_SESSION['home_user'];
if(isset($_REQUEST['user'])) {
	$userid = $_REQUEST['user'];
}

if($userid == $_SESSION['home_user']) {
	$query = "select product.thumb, user.thumb, firstname, surname, name, user.userid, product.productid from product, user, buy_product where product.productid=buy_product.productid and user.userid=buy_product.userid and product.userid=" . $_SESSION['home_user'];
	$result = mysql_query($query);
	$tmp_string = "";

	if($result){

		if(mysql_num_rows($result) > 0) {
		
			$tmp_string .= "<table width=92%><tr><td><div class='rounded-corners' ><b><font size=6>" . $_SESSION['user_name'] . " <img src='arrow.jpg' width=20px height=20px> Purchase Requests(" . mysql_num_rows($result) . ") </b></font></div><p>";
			$query = "update alerts set product=0 where userid=$userid";
			$temp = mysql_query($query);
			
			$tmp_string .= "<div class='rounded-corners' style='border: 2px solid red'><table>";
		}
		
		include('banner.php');
		drawBanner(false, $userid);

		while($row = mysql_fetch_array($result)){
			$tmp_string .= "<tr><td>";
			$tmp_string .= "<div $hover onclick=\"window.location = 'user_page.php?user=" . $row ['userid'] . "'\">";
			$tmp_string .= "<td><a href='user_page.php?user=" . $row ['userid'] ."'><img src='" . $row [1] . "' height=70px width=70px></a>";
			$tmp_string .= "<td><a href='user_page.php?user=" . $row ['userid'] ."'><b>" .$row ['firstname'] . " " . $row ['surname'] ."</b></a><br>";
			$tmp_string .= "<td><b>Would Like To Buy</b>";
			$tmp_string .= "<td><a href='show_product.php?id=" . $row ['productid'] ."'><img src='" . $row [0] . "' height=70px width=70px></a>";
			$tmp_string .= "<td><a href='show_product.php?id=" . $row ['productid'] ."'><b>" .$row ['name'] ."</b></a><br>";
			$tmp_string .= "</div>";
			
			$tmp_string .= "<td width=5%><td><td><a href='accept_purchase.php?id=" . $row['productid'] . "&user=" . $row ['userid'] ."'><img src='accept1.jpg' onmouseover=\"this.src='accept2.jpg';\" onmouseout=\"this.src='accept1.jpg';\"></a>";
			$tmp_string .= "<td><a href='decline_purchase.php?id=" . $row['productid'] . "&user=" . $row ['userid'] ."'><img src='reject1.jpg' onmouseover=\"this.src='reject2.jpg';\" onmouseout=\"this.src='reject1.jpg';\"></a>";
			$tmp_string .= "<td width=3%><td><a href='delete_product.php?id=" . $row ['productid'] ."'><img src='not_avail.jpg'></a>";
		}
		
		if(mysql_num_rows($result) > 0) {
			$tmp_string .= "</table></div></table><p>";
		}

	} else {
		die(mysql_error()); // useful for debug
	}

	echo $tmp_string;
} else {

	include('banner.php');
	drawBanner(false, $userid);

	include('check_privacy.php');
	checkAccessRights($userid, "friends");
}

$query = "select firstname, surname from user where userid=$userid";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$username = $row['firstname'] . " " . $row['surname'];


echo "<div class='layout' ><b><font size=6>$username <img src='arrow.jpg' width=20px height=20px> Buy and Sell Anything! </b></font></div><p>";



if(isset($_REQUEST['l_p']) == true) {
	echo "<div class='layout'><center><table><tr><td><a href='buy_sell.php'><font size=4>Buy</font></a><td width=20%><td><font size=4><b>Sell</b></font></table></center></div><P>";
	
	?>
	
	<div class='layout' ><form ACTION="post_item.php"  METHOD="post" enctype="multipart/form-data">

	<table>

	<tr>
	<td><label for="product"><b>Product Name</b></label>
	<td><input type="text" name="product" size="60">

	<tr>
	<td><label for="keywords"><b>Tags/Keywords<br> (limit 20 words)</b></label>
	<td><input type="text" name="keywords" size="60">

	<tr>
	<td><label for="price"><b>Product Price $</b></label>
	<td><input type="text" name="price" size="60">

	<tr>
	<td class='label'><label for="description"><b>Product Description</b></label>
	<td class='label'><textarea name="description" cols="45" rows="3"></textarea>
	
	<tr>
	<td class='label'><label for="image"><b>Product Image</b></label>
	<td class='label'><input type="file" name="image">

	<tr><td>
	<tr><td>
	<tr><td>
	<tr><td>
	<tr><td>
	<tr><td>
	<td><input type="image" src="sell_item1.jpg" onmouseover="this.src='sell_item2.jpg'" onmouseout="this.src='sell_item1.jpg'" VALUE="Submit">

	</table>
	</form></div><P>

	<?php
	
	$query = "select thumb, name, price, productid from product where userid=" . $_SESSION['home_user'];
	$result = mysql_query($query);
	
	if($result == false) {
		die(mysql_error());
	}
	
	echo "<P><div class='layout'><center><h2>Items For Sale</h2></center><table>";

	while($row = mysql_fetch_array($result)) {
	    echo "<tr><td width=100% $hover onclick=\"window.location = 'show_product.php?id=" . $row ['productid'] . "'\"><table><tr>";
		echo "<td><a href='show_product.php?user=" . $row ['productid'] . "'><img src='" . $row ['thumb'] . "' height=70px width=70px></a>";
		echo "<td><a href='show_product.php?user=" . $row ['productid'] . "'><b>" .$row ['name'] ."</b></a><br><b>$" . $row['price'] . "</b>";
		

		echo "</table><td>";

	}
	
	echo "</table></div></table>";

} else {

	echo "<div class='layout'><center><table><tr><td><b><font size=4>Buy</font></b><td width=20%><td><a href='buy_sell.php?l_p'><font size=4>Sell</font></a></table></center></div><P>";
	
	echo "<div class='layout'><center><table><tr>";
	echo "<form ACTION=\"search.php?type=1&user=$userid\" METHOD=POST autocomplete=\"off\">";
	
	?>
	
	<td valign=middle><input type="text" style="height: 35px;font-size:20px;" name="search" size="80" onkeyup="showSearchRes('friends_page', this.value, 9, 10);"></td>
	<td valign=middle><input type="image" VALUE="Search" src='search1.jpg' onmouseover='this.src="search2.jpg"' onmouseout='this.src="search1.jpg"'></td>

	</form></table></center></div><p><div class='layout' id='friends_page'></div></table>
	
	
	<?php
}


$db->disconnect(); 


?>

</div>