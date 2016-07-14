<?php
session_start();

// returns an Array of User Cart Data that you can loop on the Cart Page.
function getCartItemsAsArray() {
  $cartItems = array();
  foreach ($_SESSION['cart'] as $product => $values){
    //print_r($_SESSION['cart']);
    $productID = trim($product, "g");
    $cartItems["$productID"] = $values;
    $cartItems["$productID"]['quantity'] = $values[0];
    $cartItems["$productID"]['title'] = $values[1];
    $cartItems["$productID"]['price']= $values[2];
  }
  //print_r($cartItems);
  return $cartItems;
}

// Add up the totals for the items in the cart
function getCartSubTotal() {
  $total = 0;
  foreach ($_SESSION['cart'] as $product => $values) {
    $quantity = $_SESSION['cart'][$product]['quantity'];
    $price = $_SESSION['cart'][$product]['price'];
    $total += $price * $quantity;
  }
  return $total;
}

// Add an item to the cart
function addToCartByProductID($productID) {
  if (!isset($_SESSION['cart']["g"."$productID"])) {
    $row = getPriceAndNameByProductID($productID);
    $title = $row['product_title'];
    $price = $row['product_price'];
    $_SESSION['cart']["g"."$productID"]["quantity"] = 1;
    $_SESSION['cart']["g"."$productID"]["title"] = $title;
    $_SESSION['cart']["g"."$productID"]["price"] = $price;
  } else {
  $_SESSION['cart']["g"."$productID"]["quantity"] += 1;
  }
}

// Remove an item from the cart
function removeFromCartByProductID($productID) {
  if (isset($_SESSION['cart']['g'."$productID"])) {
    if ($_SESSION['cart']['g'."$productID"] == 1) {
      unset($_SESSION['cart']['g'."$productID"]);
    } else {
      $_SESSION['cart']['g'."$productID"] -= 1;
    }
  }
}

// Update the shopping cart
function updateShoppingCart($inPost) {
  foreach ($_SESSION['cart'] as $product => $values) {
    if(isset($inPost[$product])){
      $quantity = $inPost[$product];
      // Make sure its a number
      if (! is_numeric($quantity)) {
        continue;
      }
      // Make sure its bigger then zero
      if ($quantity < "0") {
        continue;
      }
      // Make sure its smaller then 100
      if ($quantity > "100") {
        continue;
      }

      // Update the quantity of the item
      $_SESSION['cart'][$product]['quantity'] = $quantity;

      // If the user enter's a 0 quantity, remove the item
      if ($_SESSION['cart'][$product]['quantity'] == "0") {
        unset($_SESSION['cart'][$product]);
        continue;
      }
    }
  }
}

// Empty the cart
function clearCart() {
  unset( $_SESSION['cart']);
}

// Get item count
function getCartItemCount() {
  $total = 0;
  foreach($_SESSION['cart'] as $product => $value) {
    $quantity = $_SESSION['cart'][$product]['quantity'];
    $total += $quantity;
  }
  return $total;
}

// Get the price and name of a product
function getPriceAndNameByProductID($productID) {
// Connect to the database
  include_once("php-connect.php");
  $db = dbConnect();

  $cleanProductID = mysql_real_escape_string($productID);

  // Assemble the query
  $productQuery = "SELECT product_price, product_title
             FROM products
             WHERE product_id = $cleanProductID";

  // Select the database
  mysql_select_db("breakera_nes", $db);

  // Run the query
  $result = mysql_query($productQuery, $db);

  // Get the results as an associative array
  $row = mysql_fetch_assoc($result);

  // Return the row
  return $row;
}

?>
