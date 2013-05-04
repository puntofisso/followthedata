<?php


function returnJSON($name) {
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
$filecontents = file_get_contents("/docs/".$name);
print "FILE".$filecontents."$name";
}

function returnXBRL() {
$xbrl='
<?xml version="1.0" encoding="UTF-8"?>
 

<xbrli:xbrl
xmlns:ifrs-gp="http://xbrl.iasb.org/int/fr/ifrs/gp/2005-05-15"
xmlns:iso4217="http://www.xbrl.org/2003/iso4217"
xmlns:xbrli="http://www.xbrl.org/2003/instance"
xmlns:xbrll="http://www.xbrl.org/2003/linkbase"
xmlns:xlink="http://www.w3.org/1999/xlink">
 
    <xbrll:schemaRef xbrll:href="http://www.org.com/xbrl/taxonomy" xlink:type="simple"/>
    <ifrs-gp:OtherOperatingIncomeTotalByNature contextRef="J2004" 
        decimals="0" unitRef="EUR">10430000000</ifrs-gp:OtherOperatingIncomeTotalByNature>
    <xbrli:context id="BJ2004">
        <xbrli:entity>
            <xbrli:identifier scheme="www.iqinfo.com/xbrl">It\'s the LAW!!!</xbrli:identifier>
        </xbrli:entity>
        <xbrli:period>
            <xbrli:instant>2004-01-01</xbrli:instant>
        </xbrli:period>
    </xbrli:context>
</xbrli:xbrl>
';
return $xbrl;
}

function returnSomething($var) {
	
	$answer = array();
	$query = "";
	$result = mySQLquery($query);
	while($row = mysql_fetch_assoc( $result )) {
		$answer[] = $row['keyword']; // this is a push operation. PHP!
	}
	
	return json_encode($answer);
}

function mySQLquery($query) {
	include('config.php');
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
