<?php
class MySQLDatabase{
var $link;
function connect($user, $password, $database){
$this->link = mysql_connect('localhost', $user, $password);
if(!$this->link){
die('Not connected : ' . mysql_error());
}
$db = mysql_select_db($database, $this->link);
if(!$db){
die ('Cannot use : ' . mysql_error());
}
return $this->link;
}
function disconnect(){
mysql_close($this->link);
}
}

$db = new MySQLDatabase(); // create a Database object
$db->connect("ce","ce","meetup");


?>