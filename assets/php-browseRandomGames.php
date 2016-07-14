<?php
//
// Comp 199 - Random Games
// Mere Cats
// Rory Drysdale
// May 4th, 2012
//
// Function to display all products in a given category

function randomProducts($numberOfProducts) {

  // Connect to the database
  include_once("php-connect.php");
  $db = dbConnect();

  // Assemble the query
  $productQuery = "SELECT product_id, product_title, filename, width, height, product_price, product_description, category_id
              FROM product_images RIGHT OUTER JOIN products
              ON products.thumbnail_id = product_images.product_image_id
              ORDER BY product_title ASC";

  // Select the database
  mysql_select_db("breakera_nes", $db);

  // Run the query
  $result = mysql_query($productQuery, $db);

  // If there was no results, display an error
  if (! $result) {
    echo '<h3>There are no results to display.</h3>';
  }

  // Define Column Counter
  $colCounter = 0;

  $games = array();

  while ( count($games) < $numberOfProducts) {
    $random = mt_rand(0, mysql_num_rows($result));
    mysql_data_seek($result, $random);
    $row = mysql_fetch_assoc($result);

    if ( in_array($row['product_id'], $games)) {
      continue;
    }

    $games[] = $row['product_id'];

    if ($row['filename'] == null) {
      $row['filename'] = 'default.png';
      $row['width'] = '98';
      $row['height'] = '120';
    }
    echo '<a name ="'.$row['product_id'].'"></a>';
    echo '<div class="game">';
    echo '<h3>'.$row['product_title'].'</h3>';
    echo '<img src="/assets/images-games/'.$row['filename'].'" width="'.$row['width'].'" height="'.$row['height'].'" alt="'.$row['product_title'].'" />';
    echo '<div class="details">';
    //echo '<span><a href="/cart/?g='.$row['product_id'].'">$9.99 - Add/View</a></span>';
    echo '<a href="/cart/?g='.$row['product_id'].'" class="add" title="Add to Cart"></a>';
    //echo '<button class="add"></button>';
    echo '<span class="price">$'.$row['product_price'].'</span>';
    echo '<p>'.$row['product_description'].'<br /></p>';
    //echo '<span class="more">&gt; <a href="#" title="View more details">more</a></span>';
    echo '</div>';
    echo '<div class="clear"></div>';
    echo '</div>';
  }
}

// End the program
?>
