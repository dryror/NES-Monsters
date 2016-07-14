<?php
//
// Comp 199 - Products list
// Mere Cats
// Rory Drysdale
// April 27th, 2012
//

// Function to display all products in a given category
function products($catID) {

  // Connect to the database
  include_once("php-connect.php");
  $db = dbConnect();

  // Assemble the query
  $productQuery = 'SELECT product_id, product_title, filename, width, height, product_price, product_description
              FROM product_images RIGHT OUTER JOIN products
              ON products.thumbnail_id = product_images.product_image_id
              WHERE products.category_id = '.mysql_real_escape_string($catID).'
            ORDER BY product_title ASC';

  // Select the database
  mysql_select_db("breakera_nes", $db);

  // Run the query
  $result = mysql_query($productQuery, $db);

  // If there was no results, display an error
  if (! $result) {

  }
  for ($i = 0; $i < mysql_num_rows($result); $i++) {
    $row = mysql_fetch_assoc($result);
    if ($row['filename'] == null) {
      $row['filename'] = 'default.png';
      $row['width'] = '98';
      $row['height'] = '120';
    }
    echo '<a name ="'.$row['product_id'].'"></a>';
    echo '<div class="game">';
    echo '<h3>'.$row['product_title'].'</h3>';
    echo '<img src="/assets/images-games/'.$row['filename'].'" width="'.$row['width'].'" height="'.$row['height'].'" alt="'.$row['product_title'].'" border="0" />';
    echo '<div class="details">';
    //echo '<span><a href="/cart/?g='.$row['product_id'].'">$9.99 - Add/View</a></span>';
    echo '<a href="/cart/?g='.$row['product_id'].'" class="add" title="dummy"></a>';
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
