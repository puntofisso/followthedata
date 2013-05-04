<?
include("api.php");
require("Toro.php");

// /
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
      print "Countries available";
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

    "/country" => "getCountryHandler",
    "/country/:string" => "getCountryDataHandler",
    "/country/:string/:string" => "getCountryValueHandler",

    "/company" => "getCompanyHandler",
    "/company/:string" => "getCompanyDataHandler",
    "/company/:string/:string" => "getCompanyValueHandler",

    "/value/country/:string/:number/:number" => "getCountryByValueDataRangeHandler",
    "/value/company/:string/:number/:number" => "getCompanyByValueDataRangeHandler",

));
