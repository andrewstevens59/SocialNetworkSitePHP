

<?php


session_start();

include('connectMySQL.php'); 

include('banner.php');
drawBanner(false, $_SESSION['home_user']);

$query = "select name, keywords, price, description from product where productid = " . $_REQUEST['id'];
$result = mysql_query($query);


if($result){

echo "<div class='layout'><font size=6><b>Edit Details</b></font></div><p>";
		
	if($row = mysql_fetch_array($result)){

?>

<div class='layout' >

<?php
echo "<form ACTION='save_product_details.php?id=" . $_REQUEST['id'] . "'  METHOD='post' enctype='multipart/form-data'>";

?>

<table>

<tr>
<td><label for="product"><b>Product Name</b></label>
<td><input type="text" name="product" size="60" value="<?php  echo $row['name'];  ?>">

<tr>
<td><label for="keywords"><b>Tags/Keywords<br> (limit 20 words)</b></label>
<td><input type="text" name="keywords" size="60" value="<?php  echo $row['keywords'];  ?>">

<tr>
<td><label for="price"><b>Product Price $</b></label>
<td><input type="text" name="price" size="60" value="<?php  echo $row['price'];  ?>">

<tr>
<td class='label'><label for="description"><b>Product Description</b></label>
<td class='label'><textarea name="description" cols="45" rows="3" ><?php  echo $row['description'];  ?></textarea>

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
<td><input type="image" VALUE="Submit" src='save1.jpg' onmouseover='this.src="save2.jpg"' onmouseout='this.src="save1.jpg"'>

</table>


</form>
</div>

</div>



<?php

}
} else {

	die(mysql_error()); 
}

$db->disconnect(); 


?>


