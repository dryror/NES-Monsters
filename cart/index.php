<?php
session_start();

include_once("../assets/php-shoppingCart.php");

$productID = $_GET['g'];

// Add the product submitted from the query string to the cart
if ($productID != null) {
  // Don't add the same item twice if the browser was refreshed
  if ($_SESSION['lastItem'] != $productID) {
  addToCartByProductID($productID);
    $_SESSION['lastItem'] = $productID;
  }
}

// Update the cart if it has been changed
updateShoppingCart($_POST);

if(count($_GET) > 0 || count($_POST) > 0) {
  $url = "Location: http://". $_SERVER['HTTP_HOST'] ."/cart/";
  header($url);
  exit;
}

// Echo HTTP_HOST for Trouble Shooting
// echo '<pre>'. $_SERVER['HTTP_HOST'] .'</pre>';

// Header for the page
include_once '../assets/php-header.php';

// Display area
echo '
<div class="content-inner">';

echo '
  <h2 title="Shopping Cart">Shopping Cart</h2>';

// if there is no items in the cart, display an error and get out
$productCount = getCartItemCount();
if ($productCount == 0) {
  echo '
  <div class="cart-no-items">
    <p class="cart-no-items">There are no items in your Shopping Cart.</p>
    <p>Continue shopping to add items to your cart.</p>
    <div><a href="/browse" title="Continue Browsing" id="continueBrowsing" class="button-continue-shopping-empty"></a></div>
  </div>';

  // Close Content DIV
  echo '</div>';
  include_once("../assets/php-footer.php");
  exit;
}

// Display the items with the quantity, price, and total
echo '
  <p>Enter a quantity of 0 to delete the cart item.</p>
  <form method="post" action="/cart/">
  <table cellpadding="4" cellspacing="1" border="0" class="cart">
  <tr>
    <th align="center">Items</th>
    <th width="80" align="center">Quantity</th>
    <th width="80" align="center">Price</th>
    <th width="80" align="center">Total</th>
  </tr>';

foreach ( $_SESSION['cart'] as $product => $values) {
    $price = $_SESSION['cart'][$product]['price'];
    $title = $_SESSION['cart'][$product]['title'];
    $quantity = $_SESSION['cart'][$product]['quantity'];
    $total = $price * $quantity;
  // Ouput HTML
  echo '
  <tr>
    <td align="left" valign="middle">'.$title.'</td>
    <td align="center" valign="middle"><input type="text" name="'.$product.'" value="'.$quantity.'" class="quantity" size="3" maxlength="2" /></td>
    <td align="right" valign="middle">$'. number_format($price, 2, ".", ",") .'</td>
    <td align="right" valign="middle">$'. number_format($total, 2, ".", ",") .'</td>
  </tr>';
}

echo '
</table>';

// Display the subtotal
$subTotal = getCartSubTotal();

echo '
<table cellpadding="4" cellspacing="0" border="0" class="subtotal">
  <tr>
    <td align="right"><strong>Subtotal:</strong></td>
    <td width="80" align="right" class="subtotal">$'. number_format($subTotal, 2, ".", ",") .'</td>
  </tr>
</table>';

// Finish Form
echo '<input type="submit" value="" class="button-update-cart"><div class="clear"></div></form>';

// Display the subtotal
// $subTotal = getCartSubTotal();
// echo '<h3>Your total is $'.$subTotal.'</h3>';

// Continue browsing link
echo '
  <div class="cart-options">
    <a href="/browse" title="Continue Browsing" id="continueBrowsing" class="button-continue-shopping"></a>
    <a href="/checkout" title="Proceed to Checkout" id="Checkout" class="button-proceed-to-checkout"></a>
    <div class="clear"></div>
  </div>';

// End of display area
echo '</div>';

// Footer file for the page
include_once('../assets/php-footer.php');
?>
