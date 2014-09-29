<?php

	/*
		PHP SMILEY by shafiul.progmaatic.com
		Easy Smiley Conversion!
		
		HOW-TO-USE:
		-----------
		require_once('smiley.php');
		$converted_text = smiley($non-converted-text);
		echo $converted_text;
		----------------------------------------------
		
		LICENSE: KEEP THE AUTHOR INFORMATION INTACT FOR LEGAL USE!!!
		
		************ AUTHOR INFORMATION***************
		
		Developed by Shafiul Azam 
		Contact: ishafiul@gmail.com
		
		**********************************************
		
		Download From: http://sourceforge.net/projects/smiley
	
	*/

	function smiley($text)
	{
		// Settings: Change necessary settings here! //
		
		$path = "./smiley"; // Your Image Folder's Location
		$width = '24';
		$height = '24';
		
		// Smiley Codes & Image File-name Array - you can change as necessary
		
		$arr[":))"] = "d.png";
		$arr[":(("] = "cry.png";
		$arr[";)"] = "wink.png";
		$arr[":s"] = "s.png";
		$arr[":@"] = "angry.png";
		$arr[":)"] = "happy.png";
		$arr[":("] = "sad.png";
		$arr[":o"] = "o.png";
		$arr[":x"] = "love.png";
		$arr["b-)"] = "b.png";
		$arr[":d"] = "d.png";
		$arr[":p"] = "p.png";
		$arr["o)"] = "angel.png";
		$arr[":-b"] = "nerd.png";
		$arr[":*"] = "kiss.png";
		$arr["x("] = "angry.png";
		
		// DON'T CHANGE ANYTHING BELOW to avoid malfunction!!!
		
		$code_arr = array_keys($arr);
		foreach($code_arr as $code)
			$text = str_ireplace($code, "<img width = '" . $width . "' height = '" . $height . "' src='$path/" . $arr[$code] . "'>" , $text);
		// Done! Return text
		return $text;			
	}
	
?>