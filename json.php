<?php  header('Content-Type: application/json'); ?>

{ <?php
  include "goat-ipsum.php";
  if(isset($_GET['count'])){
     echo "\"content_elements\" : [";
         for ($x = 0; $x <= $_GET['count']; $x++) {
              $words = isset($_GET['words']) ? intval($_GET['words']) : 20;
              $words2 = isset($_GET['words_max']) ? intval($_GET['words_max']) : isset($_GET['words']) ? intval($_GET['words']) : 100;
              $words = min($words,$words2,1000);
              $words2 = min($words2,1000);
              $paragraphs = isset($_GET['paragraphs']) ? intval($_GET['paragraphs']) : rand ( 3 , 7 );
              $paragraphs= min($paragraphs,500);
              $paragraphs2 = isset($_GET['p2']) ? intval($_GET['p2']) : $paragraphs;
                $count = intval($_GET['count']);
            echo "{";
              echo "\"id\" :";
              echo json_encode($x+1). ",";
              echo "\"html\" :";
              echo json_encode(phpsum($words, $words2, $paragraphs, $paragraphs2)). ",";
              echo "\"paragraphs\" :";
              echo json_encode($paragraphs). ",";
              echo "\"words\" :";
                echo json_encode($words). ",";
              echo "\"words_max\" :";
                echo json_encode($words2);
            if ($x < $count ) {
                   echo "}, ";
            }
            else{
                echo "}";
            }
        }
     echo "]" . ",";
     echo "\"count\" :";
                echo json_encode($count);
  }
  else{
      $words = isset($_GET['words']) ? $_GET['words'] : 20;
      $words2 = isset($_GET['words_max']) ? $_GET['words_max'] : isset($_GET['words']) ? $_GET['words'] : 100;
      $words = min($words,$words2,1000);
      $words2 = min($words2,1000);
      $paragraphs = isset($_GET['paragraphs']) ? $_GET['paragraphs'] : rand ( 3 , 7 );
      $paragraphs= min($paragraphs,500);
      $paragraphs2 = isset($_GET['p2']) ? $_GET['p2'] : $paragraphs;
     
    echo "\"html\" :";
    echo json_encode(phpsum($words, $words2, $paragraphs, $paragraphs2)). ",";
    echo "\"paragraphs\" :";
    echo json_encode($paragraphs);
  }
//ASSIGN VARIABLES TO USER INFO
  $time = date("M j G:i:s Y"); 
  $ip = getenv('REMOTE_ADDR');
  $userAgent = getenv('HTTP_USER_AGENT');
  $referrer = getenv('HTTP_REFERER');
  $query = getenv('QUERY_STRING');

//COMBINE VARS INTO OUR LOG ENTRY
  $msg = "IP: " . $ip . " TIME: " . $time . " REFERRER: " . $referrer . " SEARCHSTRING: count-" . $count  .",w-" . $words . ",w2-" . $words2 . ",p-" . $paragraphs . ",p2-" . $paragraphs2 . " METHOD: ipsum.json USERAGENT: " . $userAgent;

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
}