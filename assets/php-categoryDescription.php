<?php
//
// Comp 199 - Category Name and Description
// Mere Cats
// Rory Drysdale
// April 28th, 2012
//

// Function to display the category name and description give a category_id
function categoryDesc($catID) {

  // Connect to the database
  include_once("php-connect.php");
  $db = dbConnect();

  $cleanCatID = mysql_real_escape_string($catID);

  // Assemble the query
  $categoryQuery = "SELECT category_name, category_description
              FROM product_categories
              WHERE category_id = $cleanCatID";

  // Select the database
  mysql_select_db("breakera_nes", $db);

  // Run the query
  $result = mysql_query($categoryQuery, $db);

  // If there was no results, display the general page
  if (! $result) {
    $row = array(
      "category_name" => "Some Of Our Classic Nintendo Games",
      "category_description" => "Here is a random selection of some of the games we carry, please select a category to view more games."
    );
    return $row;
  }

  // Get the name and description and return them
  $row = mysql_fetch_assoc($result);

  return $row;
}

// End the program
?>
