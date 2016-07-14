<?php
session_start();
include_once '../assets/php-header.php';

// Used on the shopping cart page to make sure a refresh doesn't add more items
if (isset($_SESSION['lastItem'])) {
  unset($_SESSION['lastItem']);
}

?>

<div class="categories">
  <h2 class="categories" title="Categories">Categories</h2>
  <ul class="categories">
    <?php include_once('../assets/php-categories.php');
    category();
    ?>
  </ul>
</div>

<div class="content">
  <?php
  $catID = $_GET["c"];

  include_once("../assets/php-categoryDescription.php");
  $row = categoryDesc($catID);
  $name = $row['category_name'];
  $desc = $row['category_description'];
  ?>
  <h2><?php echo $name; ?></h2>
  <p><?php echo $desc; ?></p>
  <?php if ($name == "Some Of Our Classic Nintendo Games") {
        $name = "Classic NES";
      } ?>

  <h2>Our <?php echo $name; ?> Games</h2>



  <div class="products">
    <?php
    if ($catID != null) {
      include_once("../assets/php-products.php");
      products($catID);
    } else {
      $numberOfProducts = 6;
      include_once('../assets/php-browseRandomGames.php');
      randomProducts($numberOfProducts);
     }
    ?>

  </div>
</div>

<?php

include_once '../assets/php-footer.php';

?>
