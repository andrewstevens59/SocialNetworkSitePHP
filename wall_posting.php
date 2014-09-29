
<script type="text/javascript">
	
	var tmp;
	var curr_user1;
	var curr_user2;
	var query;
	var userid;
	var title;
	
	function comment(count, userid1, userid2) {

		if(tmp != undefined) {
			document.getElementById(tmp).style.display="none";
		}

		document.getElementById(count).style.display="block";
		curr_user1 = userid1;
		curr_user2 = userid2;
		tmp = count;
		return false;
	}
	
	userAgentLowerCase = navigator.userAgent.toLowerCase();
	 
	function resizeTextarea(t) {
	  if ( !t.initialRows ) t.initialRows = t.rows;
	 
	  a = t.value.split('\n');
	  b=0;
	  for (x=0; x < a.length; x++) {
		if (a[x].length >= t.cols) b+= Math.floor(a[x].length / t.cols);
	  }
	 
	  b += a.length;
	 
	  if (userAgentLowerCase.indexOf('opera') != -1) b += 2;
	 
	  if (b > t.rows || b < t.rows)
		t.rows = (b < t.initialRows ? t.initialRows : b);
	}
	
	// Detect if the browser is IE or not.
	// If it is not IE, we assume that the browser is NS.
	var IE = document.all?true:false;

	// If NS -- that is, !IE -- then set up for mouse capture
	if (!IE) document.captureEvents(Event.MOUSEMOVE);

	// Set-up to use getMouseXY function onMouseMove
	document.onmousemove = getMouseXY;

	// Temporary variables to hold mouse x-y pos.s
	var tempX = 0;
	var tempY = 0;

	// Main function to retrieve mouse x-y pos.s

	function getMouseXY(e) {
	  if (IE) { // grab the x-y pos.s if browser is IE
		tempX = event.clientX + document.body.scrollLeft;
		tempY = event.clientY + document.body.scrollTop;
	  } else {  // grab the x-y pos.s if browser is NS
		tempX = e.pageX;
		tempY = e.pageY;
	  }  
	  return true
	}
	
	function showLikes(id, type) {
	
		var xmlhttp;
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}
		else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

				var text = xmlhttp.responseText;
				document.getElementById("alert1").innerHTML = text;
				document.getElementById("alert1").style.display="block";
				document.getElementById("alert1").style.top = tempY;
				document.getElementById("alert1").style.left = tempX;
			}
		}

		var text = "people_who_like.php?id=" + id + "&type=" + type;
		
		xmlhttp.open("GET", text, true);
		xmlhttp.send();
		
		return false;
	}

	
	</script>

<?php

function displayWall($query, $userid, $title, $page_type) {

	include('get_wall_posting.php');
	getWallPosting($query, $userid, $title, $page_type);
	
}

?>
