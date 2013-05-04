<?
include("api.php");
require("Toro.php");

class RootHandler {
    function get() {
      echo "Follow The Data";
    }
}


// $keywords = comma-separated list of keywords
class searchMPHandler {
    function get($keywords) {
      //header('Access-Control-Allow-Origin: *');
      print searchMP($keywords);
    }
}



class getTWFYidHandler {
    function get($uid) {
      //header('Access-Control-Allow-Origin: *');
      print getTWFYid($uid);
    }
}
Toro::serve(array(
    "/" => "RootHandler",
    "/country/:alpha" => "searchMPHandler",
    "/company/:alpha" => "getTWFYidHandler",
));
