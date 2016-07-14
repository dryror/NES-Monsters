<?php
//
// Comp 199 - Add to cart
// Mere Cats
// Rory Drysdale
// May 10th, 2012
//
// Function to add an item to the cart

function addToCart($productID) {

  // Connect to the database
  include_once("php-connect.php");
  $db = dbConnect();

  // Assemble the query
  $productQuery = "SELECT product_id, product_title, product_price
              FROM products
              WHERE product_id = $productID
              ORDER BY product_title ASC";

  // Select the database
  mysql_select_db("hegemony_nes", $db);

  // Run the query
  $result = mysql_query($productQuery, $db);

  // If there was no results, display an error
  if (! $result) {
    echo '<h3>There are no results to display.</h3>';
  }

  $row = mysql_fetch_assoc($result);
  return $row;

}

// End the program
?>
