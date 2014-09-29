<?php
 
class People {
 
    function exists($ip, $db) {

        $sql = "SELECT 1 FROM users_online WHERE ip = " . ip2long($ip);
        $result = mysql_query($sql);
		
		if($result == false) {
			die(mysql_error());
		}
		
        $row = mysql_fetch_array($result);
 
        if (!empty($row)) {
            return true;
        }
        else {
            return false;
        }
    }
 
    function online($db) {
 
        $sql = "SELECT COUNT(*) as counted FROM users_online";
		$result = mysql_query($sql);
        $row = mysql_fetch_array($result);
 
        return $row['counted'];
    }
 
    function insert($ip, $db) {
 
		$sql = "insert into users_online values (" . $_SESSION['home_user'] . ", NOW(), " . ip2long($ip) . ")";
        $result = mysql_query($sql);
		
		if($result == false) {
			die(mysql_error());
		}
    }
 
    function update($ip, $db) {
 
        $sql = "update users_online set ip=" . ip2long($ip) . ", time=NOW()";
        $result = mysql_query($sql);
		
		if($result == false) {
			die(mysql_error());
		}
    }
 
    function truncate($db) {
 
        $sql = "DELETE FROM users_online WHERE time < SUBTIME(NOW(),'0 0:10:0')";
        $result = mysql_query($sql);
    }
 
}
 
?>