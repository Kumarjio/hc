<?php
  require_once 'autoload.php'; 
  require_once 'lib/AuthorizeNetAIM.php'; 
   
  // API credentials only need to be defined once
  define("AUTHORIZENET_API_LOGIN_ID", "2qFdY5v74");
  define("AUTHORIZENET_TRANSACTION_KEY", "842z6pK8Rqg8r9LJ");
  define("AUTHORIZENET_SANDBOX", true);
   
  $sale = new AuthorizeNetAIM;
  $sale->amount = "5.99";
  $sale->card_num = '4111111111111111';
  $sale->exp_date = '0418';
  $response = $sale->authorizeAndCapture();
  if ($response->approved) {
    echo "Success! Transaction ID:" . $response->transaction_id;
  } else {
    echo "ERROR:" . $response->error_message;
  }
?>