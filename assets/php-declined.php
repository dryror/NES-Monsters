<?php
session_start();

function declined ($inGet) {
  $errorMessage = htmlspecialchars($inGet['messageText']);

  // Output Transaction Declined HTML
  echo '
  <h2 title="Transaction Declined">Transaction Declined</h2>
  <div class="declined">
    <h3>The transaction has been declined.</h3>
    <div class="declined-reason"><strong>Reason:</strong><br />'.$errorMessage.'</div>
    <p>Please review your Checkout Information.</p>
    <a href="/checkout/" class="button-return-to-checkout" title="Return to Checkout"></a>
  </div>';
}

?>
