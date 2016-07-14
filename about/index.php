<?php
session_start();
include_once '../assets/php-header.php';


?>

<div class="content-inner">
  <h2>About Us</h2>
  <p>NES Monsters was created by <b>Rory Drysdale</b>, <b>Chris Rail</b>, and <b>Nick Dronsfield</b>  as a year end project for the Computer Systems Technology program at Camosun Collage. </p>
<p>The site makes use of various technologies covered in the program, including MySQL and PHP. Chief among these is MySQL, which is used to populate the site's browse pages, as well as to generate some of the page links based on available categories.  We make use of PHP session information to provide the user with a shopping cart as they browse the game categories.</p>

<h3>Chris Rail<h3>
<br />
<img src= "/assets/images/chris.jpeg" alt = "Chris Rail" width="50%" height ="50%"/>
<br />
<h3>Rory Drysdale</h3>
<br />
<img src= "/assets/images/rory.jpg" alt = "Rory Drysdale" width="50%" height="50%" />
<br />
<h3>Nick Dronsfield</h3>
<br />
<img src= "/assets/images/nick.jpg" alt = "Nick Dronsfield" width="50%" height="50%" />
<br />
</div>

<?php

include_once '../assets/php-footer.php';

?>
