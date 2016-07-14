<?php
session_start();

function approved ($inGet, $invoiceHTML) {

  // Retrieve Get vars
  $trnId = $inGet['trnId'];
  $trnAmount = $inGet['trnAmount'];
  $trnDate = $inGet['trnDate'];
  $trnCustomerName = $inGet['trnCustomerName'];
  $trnEmailAddress = $inGet['trnEmailAddress'];
  $trnPhoneNumber = $inGet['trnPhoneNumber'];

  // Display Transaction information
  echo '
    <h2 title="Transaction Complete">Transaction Complete</h2>
    <p>Thank you for your order, <strong>'.$trnCustomerName .'</strong></p>
    <p>Your transaction for <strong>$'.$trnAmount.'</strong> was approved on <strong>'.$trnDate.'</strong>.</p>
    <p>Transaction number: <strong>'.$trnId.'</strong></p>';

  echo $invoiceHTML;

  echo '
    <h3 align="center">Thank you for playing!</h3>
    <a href="/" title="Return to Home Page" class="button-return-to-home"></a>';

  // Connect to the database
    include_once("php-connect.php");
    $db = dbConnect();

    // Select the database
    mysql_select_db("breakera_nes", $db);

    // Insert the transaction
  mysql_query("INSERT INTO transactions (trnId, trnAmount, trnDate, trnCustomerName, trnEmailAddress, trnPhoneNumber)
         VALUES ($trnId, '$trnAmount', '$trnDate', '$trnCustomerName', '$trnEmailAddress', '$trnPhoneNumber')");

}

?>
