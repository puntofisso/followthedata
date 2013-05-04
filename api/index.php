<?
include("api.php");
require("Toro.php");

// 
class RootHandler {
    function get() {
      echo "Follow The Data API v0.9. 04052013<br/>";
      echo "Available endpoints:<br/>";
      echo "- /: general info, version, date<br/>";
      echo "- /country: info by country<br/>";
      echo "- /company: info by company<br/>";
      echo "- /value: search country and companies by value range<br/>"; 
    }
}

// /example
class getExampleHandler {
    function get() {

      
    }
}

// /xbml
class getXBRLHandler {
    function get($uid) {
      //header('Access-Control-Allow-Origin: *');
      print returnXBRL();
    }
}

// /country
class getCountryHandler {
    function get() {
      //header('Access-Control-Allow-Origin: *');
      
      $m = new MongoClient("mongodb://178.79.162.184");
      $db = $m->followthedata;
      $cursor = $db->countries->find(array(), array("name" => 1));
      
        $dict = array();
        foreach ($cursor as $document) {
                $dict[] = $document;
        }
        print json_encode($dict);
    }
}

class getCountryDataHandler {
    function get($country) {
      //header('Access-Control-Allow-Origin: *');
      print "All values for $country";
    }
}

class getCountryValueHandler {
    function get($country,$param) {
      //header('Access-Control-Allow-Origin: *');
      print "Value of $param for $country";
    }
}

// /company
class getCompanyHandler {
    function get() {
      //header('Access-Control-Allow-Origin: *');
      print "Companies available";
    }
}

class getCompanyDataHandler {
    function get($company) {
      //header('Access-Control-Allow-Origin: *');
      print "All data for company $company";
    }
}

class getCompanyValueHandler {
    function get($company,$param) {
      //header('Access-Control-Allow-Origin: *');
      print "Value of $param for $company";
    }
}

// /value 
class getCountryByValueDataRangeHandler {
    function get($param, $min, $max) {
      //header('Access-Control-Allow-Origin: *');
      print "$param, $min, $max";
    }
}

class getCompanyByValueDataRangeHandler {
    function get($param, $min, $max) {
      //header('Access-Control-Allow-Origin: *');
      print "$param, $min, $max";
    }
}

Toro::serve(array(
    "/" => "RootHandler",
    "/xbrl" => "getXBRLHandler",

    "/example" => "getExampleHandler",

    "/country" => "getCountryHandler",
    "/country/:string" => "getCountryDataHandler",
    "/country/:string/:string" => "getCountryValueHandler",

    "/company" => "getCompanyHandler",
    "/company/:string" => "getCompanyDataHandler",
    "/company/:string/:string" => "getCompanyValueHandler",

    "/value/country/:string/:number/:number" => "getCountryByValueDataRangeHandler",
    "/value/company/:string/:number/:number" => "getCompanyByValueDataRangeHandler",

));
