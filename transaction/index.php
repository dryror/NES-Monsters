<?php
// Checkout page
session_start();

$invoiceHTML = '';


// Add up the totals for the items in the cart
function getCartTotal() {
  $total = 0;

  foreach($_SESSION['cart'] as $product => $values) {
      $quantity = $_SESSION['cart'][$product]['quantity'];
    $price = $_SESSION['cart'][$product]['price'];
    $total += $price * $quantity;
  }

  return $total;
}


// Compose Invoice HTML from Session['cart']
function composeInvoice() {
  $invoiceHTML = '';

  // Open HTML Table with Table Headers
  $invoiceHTML .= '
    <table cellpadding="4" cellspacing="1" border="0" class="cart">
    <tr>
      <th align="center">Items</th>
      <th width="80" align="center">Quantity</th>
      <th width="80" align="center">Price</th>
      <th width="80" align="center">Total</th>
    </tr>';

  // Iterate each Cart Items
  foreach ($_SESSION['cart'] as $product => $values) {
      $price = $_SESSION['cart'][$product]['price'];
      $title = htmlspecialchars($_SESSION['cart'][$product]['title']);
      $quantity = $_SESSION['cart'][$product]['quantity'];
      $total = $price * $quantity;

    // Concatenate Invoice HTML
    $invoiceHTML .= '
    <tr>
      <td align="left" valign="middle">'.$title.'</td>
      <td align="center" valign="middle">'.$quantity.'</td>
      <td align="right" valign="middle">$'. number_format($price, 2, ".", ",") .'</td>
      <td align="right" valign="middle">$'. number_format($total, 2, ".", ",") .'</td>
    </tr>';
  }

  // Close HTML Table
  $invoiceHTML .= '
  </table>';

  // Display the subtotal
  $subTotal = getCartTotal();

  $invoiceHTML .= '
  <table cellpadding="4" cellspacing="0" border="0" class="subtotal">
    <tr>
      <td align="right"><strong>Order Total:</strong></td>
      <td width="80" align="right" class="subtotal">$'. number_format($subTotal, 2, ".", ",") .'</td>
    </tr>
  </table>';

  // Return Invoice HTML
  return $invoiceHTML;
}


// Clear the session stuff if the transaction was approved
// This had to be before the header file was called so the items and subtotal was updated
if (isset($_GET['trnApproved'])) {
  $isApproved = $_GET['trnApproved'];
  if ($isApproved == 1) {

    // Compose Invoice HTML
    $invoiceHTML = composeInvoice();

    // Empty the cart
    unset($_SESSION['cart']);
  }
}

// Header for the page
include_once '../assets/php-header.php';

// Section to display in
echo '<div class="content-inner">';

// If the transaction never came back display an error
if (! isset($_GET['trnApproved'])) {
  echo '<h4>Error processing transaction, please try again<h4><br>';
  echo '<a href="/checkout" title="Checkout" id="checkout>Checkout</a>';
  include_once '../assets/php-footer.php';
  exit;
}

if ($isApproved == 1) {
  include_once("../assets/php-approved.php");
  approved($_GET,$invoiceHTML);

  // Clear the user information
  unset($_SESSION['user']);
  unset($_SESSION['lastItem']);
} else {
  include_once("../assets/php-declined.php");
  declined($_GET);
}

// End of the display area
echo '</div>';

// Footer file for the page
include_once '../assets/php-footer.php';
?>
