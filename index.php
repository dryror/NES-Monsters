<?php
session_start();
$life = '3600';
setcookie(session_name(), session_id(), time()+$life);

include_once 'assets/php-header.php';

// Used on the shopping cart page to make sure a refresh doesn't add more items
if (isset($_SESSION['lastItem'])) {
  unset($_SESSION['lastItem']);
}

?>

<div class="categories">
  <h2 class="categories" title="Categories">Categories</h2>
  <ul class="categories">
    <?php
    include_once 'assets/php-categories.php';
    category();
    ?>
  </ul>
</div>

<div class="content">

  <h2>Classic Nintendo Games</h2>
  <p>Order old Nintendo games, original retro 8 bit game cartridges for sale. Every used vintage 1985 game is cleaned, tested and in great condition. Hundreds of new Nintendo NES games are purchased every day and added to the site for sale.</p>
  <p>Below is a random selection of our favorite NES games, please select a category to view more games.</p>
  <h2>Some Of Our Favorite NES Games</h2>

  <div class="products">
    <?php
    $numberOfProducts = 6;
    include_once('assets/php-randomGames.php');
    randomProducts($numberOfProducts)
    ?>

    <div class="clear"></div>

  </div>

</div>

<?php

include_once 'assets/php-footer.php';

?>
