<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>

<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />

<?php


session_start();

include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$query = "select product.description, name, price, product.image, user.image, firstname, surname, user.userid from product, user where user.userid=product.userid and productid=" . $_REQUEST['id'];
$result = mysql_query($query);


if($result){

	if($row = mysql_fetch_array($result)){
	
		echo "<div class='layout' ><center><b><font size=6>" . $row['name'] . "</font></b></center></div><p><div class='layout' >";

		echo "<center><img src='" . $row[3] . "' width=150px height=150px></center><p>";
		echo "<div style=\"background-color:#F2F2F2;\"><table><tr><td width=20%>";
		echo "<h2>Description</h2><font size=4>" . $row['description'] . "</font>";
		echo "<tr><td width=20%><h2>Price</h2><font size=4>$" . $row['price'] . "</font></td>";
		echo "<tr><td width=20%><h2>Sold By</h2><table><tr><td><a href='user_page.php?user=" . $row['userid'] . "'><img src='" . $row[4] . "' width=70px height=70px></a><td><a href='user_page.php?user=" . $row['userid'] . "'>"		. $row['firstname'] . " " . $row['surname'] . "</a></td></table>";
		
		echo "</table></div>";
		
		if($_SESSION['home_user'] != $row['userid']) {
		
			$query = "select * from buy_product where userid=" . $_SESSION['home_user'] . " and productid=" . $_REQUEST['id'];
			$tmp = mysql_query($query);
			
			if($tmp == false) {
				die(mysql_error());
			}
		
			if(mysql_num_rows($tmp) == 0) {
				echo "<P><center><a href='buy_product.php?id=" . $_REQUEST['id'] . "&user=" . $row['userid'] . "'><img src='buy1.jpg' onmouseover=\"this.src='buy2.jpg'\" onmouseout=\"this.src='buy1.jpg'\"></a></center>";
			} else {
				echo "<P><center>A Notification Has Been Sent To <a href='user_page.php?user=" . $row['userid'] . "'>" . $row['firstname'] . " " . $row['surname'] . "</a></center>";
			}
		} else {
			echo "<P><center><a href='edit_product.php?id=" . $_REQUEST['id'] . "'><img src='edit1.jpg' onmouseover=\"this.src='edit2.jpg'\" onmouseout=\"this.src='edit1.jpg'\"></a>&nbsp;&nbsp;<a href='delete_product.php?id=" . $_REQUEST['id'] . "'><img src='remove1.jpg' onmouseover=\"this.src='remove2.jpg'\" onmouseout=\"this.src='remove1.jpg'\"></a></center>";
		}
		
		echo "<div style=\"background-color:#F2F2F2;\"><h2>Photos</h2><div ><table>";
		
		$query = "select photos.image, photos.imageid from photos, product_images where product_images.imageid=photos.imageid and product_images.productid=" . $_REQUEST['id'];
		$result = mysql_query($query);
		
		if($result == false) {
			die(mysql_error());
		}
		
		$result = mysql_query($query);
		$count = 0;

		
				
		while($row1 = mysql_fetch_array($result)){
		
			if($count == 0) {
				echo "<tr>";
			}

			echo "<td><a href='" . $row1['image'] . "' rel=\"lightbox[album]\" title=\"\"><img src='" . $row1['image'] . "' width=150px height=150px></a>";
			echo "<br><a href='set_product_image.php?id=" . $_REQUEST['id'] . "&photo=" . $row1['imageid'] . "'><center><font size=2>Set Image</font></center></a>";
			
			$count = $count + 1;
			if($count >= 4) {
				$count = 0;
			}
		}
		
		
		echo "</table>";
		
		
		if($_SESSION['home_user'] == $row['userid']) {
echo "<p><form ACTION='upload_product_image.php?id=" . $_REQUEST['id'] . "'  METHOD='post' enctype='multipart/form-data'>";

?>

<table>

<tr>
<td class='label'><label for="image"><b>Upload Other Image</b></label>
<td class='label'><input type="file" name="image">


<tr>
<td>
<tr>
<td>
<tr>
<td>
<tr>
<td>

<tr>
<td><input type="image" VALUE="Submit" src='upload1.jpg' onmouseover='this.src="upload2.jpg"' onmouseout='this.src="upload1.jpg"'>

</table>


</form>

<?php
		
		
		}
		echo "</div></div>";
		
	}
	
} else {
	die(mysql_error()); // useful for debug
}

?>


</table>

<?php

$db->disconnect(); // disconnect after use is a good habit

?>