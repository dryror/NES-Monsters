<?php
include_once("php-shoppingCart.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>NES Monsters</title>
<link rel="icon" href="/assets/images/icon-browser.png" />
<link rel="apple-touch-icon" href="/assets/images/icon-iphone.png" />
<link rel="stylesheet" type="text/css" href="/assets/css-template.css" />
<link rel="stylesheet" type="text/css" href="/assets/css-hv.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/js-hv.js"></script>
</head>
<body>
<div class="wrapper">
  <header>
    <h1 title="NES Monsters"><a href="/" title="NES Monsters"><img src="/assets/images/nes-monsters-logo.png" width="400" height="62" alt="NES Monsters" /></a></h1>
    <div class="shopping-info">
      <a href="/cart" title="View your Shopping Cart"><?php echo getCartItemCount();?> Items</a>
      &nbsp;&nbsp;|&nbsp;&nbsp;
      Sub-Total: $<?php echo number_format(getCartSubTotal(), 2, ".", ","); ?>
      &nbsp;&nbsp;|&nbsp;&nbsp;
      <a href="/checkout" title="Checkout">Checkout</a>
    </div>
  </header>
<?php
// NES Monsters
// May 12 2012
// Nick Dronsfield
// Establish context sensitive navigation

// this shouldn't step on anyone's toes, but if it does I appologize in addvance




// get the current page
$currentPage= $_SERVER['PHP_SELF'];

// grab the cat_id for the selected catagory
$cat=$_GET['c'];

if ($currentPage=='/index.php') {
echo('<nav class="main">
    <a href="/" class="on">Home</a>
    <a href="/browse/">Browse</a>
    <a href="/about/">About Us</a>
    <a href="/contact/">Contact</a>
  </nav>');

  }
elseif ($currentPage=='/browse/index.php') {
echo('<nav class="main">
    <a href="/" >Home</a>
    <a href="/browse/" class= "on">Browse</a>
    <a href="/about/">About Us</a>
    <a href="/contact/">Contact</a>
  </nav>');
}

elseif ($currentPage=='/about/index.php') {
echo('<nav class="main">
    <a href="/">Home</a>
    <a href="/browse/">Browse</a>
    <a href="/about/" class= "on">About Us</a>
    <a href="/contact/">Contact</a>
  </nav>');
}

elseif ($currentPage=='/contact/index.php') {
echo('<nav class="main">
    <a href="/">Home</a>
    <a href="/browse/">Browse</a>
    <a href="/about/">About Us</a>
    <a href="/contact/" class="on">Contact</a>
  </nav>');
} else {
echo('<nav class="main">
    <a href="/">Home</a>
    <a href="/browse/">Browse</a>
    <a href="/about/">About Us</a>
    <a href="/contact/" >Contact</a>
  </nav>');
}
?>

<div class="wrapper-content">
