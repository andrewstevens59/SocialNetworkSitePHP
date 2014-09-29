

<?php

function addPartialMatch($string,  $type, $userid = -1) {
	
	if($userid < 0) {
		$userid = $_SESSION['home_user'];
	}

	$tok = strtok($string, " ");
	$count = 0;

	while ($tok != false) {
		
		for($i=0; $i<min(strlen($tok), 10); $i++) {
		
			$lower = strtolower(substr($tok, 0, $i + 1));
			$query = "insert into permute_set values ('" . $lower . "', " . $userid . ", $type)";
			$result = mysql_query($query);
		}
	
		$tok = strtok(" ");
		$count = $count + 1;
	}
	
	return $count;
}
?>