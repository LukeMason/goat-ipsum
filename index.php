<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>HTTP Goat – Ipsum</title>
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-2480926-3', 'httpgoat.com');
    ga('send', 'pageview');
  </script>

  <style>
    body{
      background-color: #fff;
      height:100%;
      font-family: 'Helvetica Neue', 'HelveticaNeue-Light', 'Helvetica Neue Light', Helvetica, Arial, "Lucida Grande", sans-serif; 

    }
    footer{
      position: absolute;
      bottom: 0;
      text-align: center;
      color:#333;
      font-size: 10px;
    }
    #container{
      min-height: 100%;
      background-color: #fff;
      padding:1em;
      max-width:980px;
      margin: auto;
    }
    h1{
     font-weight: 100;
     cursor: help;
   }
   #header{
    border-bottom: 1px solid #efefef;
  }
  p:first-letter{
   text-transform: uppercase;
 }
 p {
   font-weight: 300;
   text-indent: 1em;
   line-height: 1.5em;
 }

</style>


</head>

<body>


 <div id="container"> 
  <div id="header"> 
    <h1 title="parameters are - words words_max paragraphs">Goat Ipsum</h1> 
  </div>

  <?php
  include "goat-ipsum.php";
  $words = isset($_GET['words']) ? $_GET['words'] : 20;
  $words2 = isset($_GET['words_max']) ? $_GET['words_max'] : isset($_GET['words']) ? $_GET['words'] : 100;
  $words = min($words,$words2,1000);
  $words2 = min($words2,1000);
  $paragraphs = isset($_GET['paragraphs']) ? $_GET['paragraphs'] : rand ( 3 , 7 );
  $paragraphs= min($paragraphs,500);
  $paragraphs2 = isset($_GET['p2']) ? $_GET['p2'] : $paragraphs;
  echo phpsum($words, $words2, $paragraphs, $paragraphs2); // prints a random number of 20 to 40 words in a random number of 2 to 4 paragraphs
  

//ASSIGN VARIABLES TO USER INFO
  $time = date("M j G:i:s Y"); 
  $ip = getenv('REMOTE_ADDR');
  $userAgent = getenv('HTTP_USER_AGENT');
  $referrer = getenv('HTTP_REFERER');
  $query = getenv('QUERY_STRING');

//COMBINE VARS INTO OUR LOG ENTRY
  $msg = "IP: " . $ip . " TIME: " . $time . " REFERRER: " . $referrer . " SEARCHSTRING: " ."w-" . $words . ",w2-" . $words2 . ",p-" . $paragraphs . ",p2-" . $paragraphs2 . " METHOD: ipsum USERAGENT: " . $userAgent;

//CALL OUR LOG FUNCTION
  writeToLogFile($msg);

  function writeToLogFile($msg) {
   $today = date("Y_m_d"); 
   $logfile = $today."_log.txt"; 
   $dir = '../logs';
   $saveLocation=$dir . '/' . $logfile;
   if  (!$handle = @fopen($saveLocation, "a")) {
    exit;
  }
  else {
    if (@fwrite($handle,"$msg\r\n") === FALSE) {
     exit;
   }
   
   @fclose($handle);
 }
}

?>

</div>

</body>