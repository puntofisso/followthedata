<?php

function getTWFYid($uid) {
	$result = mySQLquery($query);
	
}

function getAllUniqueKeywords($seed) {
	
	$answer = array();
	while($row = mysql_fetch_assoc( $result )) {
		$answer[] = $row['keyword']; // this is a push operation. PHP!
	}
	
	return json_encode($answer);
}

function mySQLquery($query) {
	include('../../config/config.php');
mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die(mysql_error()." | HOST ".$DB_HOST." USER ".$DB_USER." PASS ".$DB_PASS ." NAME ".$DB_NAME." | Error on connect ");
mysql_select_db($DB_NAME) or die(mysql_error()." | HOST ".$DB_HOST." USER ".$DB_USER." PASS ".$DB_PASS ." NAME ".$DB_NAME." | Error on select db ");

$result = mysql_query("$query") or die(mysql_error()." | HOST ".$DB_HOST." USER ".$DB_USER." PASS ".$DB_PASS ." NAME ".$DB_NAME. " | Error on query " );  

// keeps getting the next row until there are no more to get
#while($row = mysql_fetch_array( $result )) {
#	// Print out the contents of each row into a table
#}
return $result; 
}

?>
