<?php

function resizeImage($file_type, $file_tmp, $ThumbWidth, $dir_thumb, $file_size) {

	//keep image type

	if($file_size){

		if($file_type == "image/pjpeg" || $file_type == "image/jpeg"){

		$new_img = imagecreatefromjpeg($file_tmp);

		}elseif($file_type == "image/x-png" || $file_type == "image/png"){

		$new_img = imagecreatefrompng($file_tmp);

		}elseif($file_type == "image/gif"){

		$new_img = imagecreatefromgif($file_tmp);

		}

		//list the width and height and keep the height ratio.

		list($width, $height) = getimagesize($file_tmp);

		//calculate the image ratio

		$imgratio=$width/$height;

		if ($imgratio>1){

		$newwidth = $ThumbWidth;

		$newheight = $ThumbWidth/$imgratio;

		}else{

		$newheight = $ThumbWidth;

		$newwidth = $ThumbWidth*$imgratio;

		}
		
		$newheight = min($newheight, $height);
		$newwidth = min($newwidth, $width);


		$resized_img = imagecreatetruecolor($newwidth,$newheight);


		//the resizing is going on here!

		imagecopyresized($resized_img, $new_img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		//finally, save the image

		ImageJpeg ($resized_img,$dir_thumb);

		ImageDestroy ($resized_img);

		ImageDestroy ($new_img);
	}
}

 
function uploadImage()

{		

$dir_thumb = "";
$dir_big = "";

//make sure this directory is writable!

$path_thumbs = "Images/thumbs/";		
$path_big = "Images/";	

//the new width of the resized image, in pixels.

$img_thumb_width = 100; // 

$extlimit = "yes"; //Limit allowed extensions? (no for all extensions allowed)

//List of allowed extensions if extlimit = yes

$limitedext = array(".gif",".jpg",".png",".jpeg",".bmp");		

//the image -> variables

$file_type = $_FILES['image']['type'];

$file_name = $_FILES['image']['name'];

$file_size = $_FILES['image']['size'];

$file_tmp = $_FILES['image']['tmp_name'];

//check if you have selected a file.

if(!is_uploaded_file($file_tmp)){

	echo "Error: Please select a file to upload!. <br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>";

	return array($dir_thumb, $dir_big);

}

//check the file's extension

$ext = strrchr($file_name,'.');

$ext = strtolower($ext);

//uh-oh! the file extension is not allowed!

if (($extlimit == "yes") && (!in_array($ext,$limitedext))) {

	echo "Wrong file extension.  <br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>";

	exit();

}

//so, whats the file's extension?

$getExt = explode ('.', $file_name);

$file_ext = $getExt[count($getExt)-1];

//create a random file name

$rand_name = md5(time() + rand(0,999999999));

//the new width variable

$ThumbWidth = $img_thumb_width;



/////////////////////////////////

// CREATE THE THUMBNAIL //

////////////////////////////////

$dir_thumb = "$path_thumbs/$rand_name.$file_ext";
resizeImage($file_type, $file_tmp, 100, $dir_thumb, $file_size);

$dir_big = "$path_big/$rand_name.$file_ext";
resizeImage($file_type, $file_tmp, 800, $dir_big, $file_size);


return array($dir_thumb, $dir_big);
}


 ?>