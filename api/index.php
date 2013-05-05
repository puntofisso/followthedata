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

      print returnJSON("resources.json");
    }
}

// /xbml
class getXBRLHandler {
    function get($uid) {
      //header('Access-Control-Allow-Origin: *');
      print returnXBRL();
    }
}

// /all
class getAllHandler {
    function get() {
      header('Content-type: application/json');
      $query = "SELECT id,name from countries;";
      $result = mySQLquery($query);
      $all = array();

      while ($row = mysql_fetch_array($result)) {
          $cid = $row[0];
          $cname = $row[1];

          $query2 = "SELECT k.* from commodities k where k.country_id = $cid and k.name in ('Oil','Gas') order by k.name;";
          $result2 = mySQLquery($query2);

          $out = array();
          while ($row2 = mysql_fetch_assoc($result2)) {

            $name = $row2["name"];
            
            $out[$name][] = $row2;
          }

          $classname= str_replace ( " " , "_" , $cname );
          $out['countryname'] = $classname;
          $all['countries'][] = $out;


      }
      print json_encode($all);

      
    }
}


// /country
class getCountryHandler {
    function get() {
      //header('Access-Control-Allow-Origin: *');
      
        $query = "SELECT name FROM countries;";
        $result = mySQLquery($query);
        $out = array();

        while ($row = mysql_fetch_assoc($result)) {
            $out[] = $row["name"];
          
        }
        print json_encode($out);
    }
}

// /country/{countryname}
class getCountryDataHandler {
    function get($country) {
      $query = "SELECT k.* from commodities k, countries c where k.country_id = c.id AND c.name = '$country';";
        $result = mySQLquery($query);
        $out = array();

        while ($row = mysql_fetch_assoc($result)) {
            $out[] = $row;
        }
        print json_encode($out);
    }
}

// /country/{countryname}/{commodityname}
class getCountryValueHandler {
    function get($country,$param) {
      //header('Access-Control-Allow-Origin: *');
      $query = "SELECT k.* from commodities k, countries c where k.country_id = c.id AND c.name = '$country' and k.name='$param';";
        $result = mySQLquery($query);
        $out = array();

        while ($row = mysql_fetch_assoc($result)) {
                $out[] = $row;
        }

        print json_encode($out);
      }
}

// /company
class getCompanyHandler {
    function get() {
      //header('Access-Control-Allow-Origin: *');
      $query = "SELECT name FROM companies;";
        $result = mySQLquery($query);
        $out = array();

        while ($row = mysql_fetch_assoc($result)) {
            $out[] = $row["name"];
          
        }
        print json_encode($out);
    }
}

// /company/{companyname}
class getCompanyDataHandler {
    function get($company) {
      $query = "SELECT c.* from companies c where  c.name = '$company';";
        $result = mySQLquery($query);
        $out = array();

        while ($row = mysql_fetch_assoc($result)) {
            $out[] = $row;
        }
        print json_encode($out);
    }
}

// /company/{companyname}/{param}
class getCompanyValueHandler {
    function get($company,$field) {
      $paramstring="$field"."_2007,$field"."_2008,$field"."_2009,$field"."_2010,$field"."_2011";
      $query = "SELECT $paramstring from companies c where  c.name = '$company';";
      
        $result = mySQLquery($query);
        $out = array();

        while ($row = mysql_fetch_assoc($result)) {
            $out[] = $row;
        }
        print json_encode($out);
    }
}

// /company/{companyname}/{param}/{year}
class getCompanyValueYearHandler {
    function get($company,$field,$year) {
      $paramstring="$field"."_"."$year";
      $query = "SELECT $paramstring from companies c where  c.name = '$company';";
      
      
        $result = mySQLquery($query);
        $out = array();

        while ($row = mysql_fetch_assoc($result)) {
            $out[] = $row;
        }
        print json_encode($out);
    }
}

// /value/country/{commodity}/{param}/{min}/{max}
class getCountryByValueDataRangeHandler {
    function get($commodity, $param, $min, $max ) {
      //header('Access-Control-Allow-Origin: *');
      
       $query = "SELECT c.name as country, k.year as year, k.$param as $param from commodities k, countries c where k.name='$commodity' AND indep_source_production_volume > $min AND indep_source_production_volume <$max AND k.country_id=c.id;";

        $result = mySQLquery($query);
        $out = array();

         while ($row = mysql_fetch_assoc($result)) {
                 $out[] = $row;
         }

         print json_encode($out);
      }
    }

// /value/company/{field}/{year}/{min}/{max}
class getCompanyByValueDataRangeHandler {
    function get($field, $year, $min, $max) {
      $param=$field."_".$year;
      //header('Access-Control-Allow-Origin: *');
      $query = "SELECT name, $param from companies where $param < $max and $param > $min;";
      print $query;
        $result = mySQLquery($query);
        $out = array();

         while ($row = mysql_fetch_assoc($result)) {
                 $out[] = $row;
         }

         print json_encode($out);
      }
    }


Toro::serve(array(
    "/" => "RootHandler",
    "/xbrl" => "getXBRLHandler",

    "/example" => "getExampleHandler",

    "/all" => "getAllHandler",

    "/country" => "getCountryHandler",
    "/country/:string" => "getCountryDataHandler",
    "/country/:string/:string" => "getCountryValueHandler",

    "/company" => "getCompanyHandler",
    "/company/:string" => "getCompanyDataHandler",
    "/company/:string/:string" => "getCompanyValueHandler",
    "/company/:string/:string/:number" => "getCompanyValueYearHandler",

    "/value/country/:string/:alpha/:number/:number" => "getCountryByValueDataRangeHandler",
    "/value/company/:string/:number/:number/:number" => "getCompanyByValueDataRangeHandler",

));
