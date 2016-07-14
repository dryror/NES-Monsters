<?php
//
// Comp 199 - Categories list
// Mere Cats
// Rory Drysdale
// April 27th, 2012
//

include_once 'php-connect.php';


$db = dbConnect();

// Function to display the category list
function category() {

  // $db = dbConnect();

  // Assemble the query
  $categoryQuery = "
    SELECT category_name, category_id
    FROM product_categories
    ORDER BY category_name ASC";

  // Run the query
  $result = mysql_query($categoryQuery) or die(mysql_error());

  // If there was no results, display an error
  if (! $result) {
    echo "No Categories<br />: mysql_num_rows($result)";
  } else {
    echo $results;

    // Display the categories in a unordered list
    // Provide a link to the browse with the appropriate category_id attached

    $cat_id= $_GET['c'];
    for ($i = 0; $i < mysql_num_rows($result)-1; $i++) {


      $row = mysql_fetch_assoc($result);

      if($cat_id==$row['category_id']){
        echo'<li><a href="/browse/?c='.$row['category_id'].'" title="'.$row['category_name'].'" class="on">';
        echo $row['category_name'].'</a></li>';
      } else {

        echo'<li><a href="/browse/?c='.$row['category_id'].'" title="'.$row['category_name'].'">';
        echo $row['category_name'].'</a></li>';
      }
    }

    // Have to add class="last" to the last one
    $row = mysql_fetch_assoc($result);

    if($cat_id==$row['category_id']){
      echo'<li><a href="/browse/?c='.$row['category_id'].'" title="'.$row['category_name'].'" class="last on">';
      echo $row['category_name'].'</a></li>';

    } else {
      echo'<li><a href="/browse/?c='.$row['category_id'].'" class="last" title="'.$row['category_name'].'">';
      echo $row['category_name'].'</a></li>';
    }
  }
}

// End the program
?>
