<?php
// Checkout page
session_start();

// Clear the user information if clear was pressed
if (isset($_GET['clear'])) {
  unset($_SESSION['user']);
}

// Shopping cart stuff
include_once '../assets/php-shoppingCart.php';

// Header for the page
include_once '../assets/php-header.php';

echo '<div class="content-inner">';
echo '<h2 title="checkout">Checkout</h2>';

// If there is nothing in the cart, show an error and get out
if (getCartSubtotal() == 0) {
    echo '
  <div class="cart-no-items">
    <p class="cart-no-items">There are no items in your Shopping Cart.</p>
    <p>Continue shopping to add items to your cart.</p>
    <div><a href="'.$_SERVER['HTTP_REFERER'].'" title="Continue Browsing" id="continueBrowsing" class="button-continue-shopping-empty"></a></div>
  </div>';

  // Close Content DIV
  echo '</div>';
  include_once("../assets/php-footer.php");
  exit;
}

$errorMessage = '';

// Display any error
if(isset($_GET['errorMessage'])) {
  $formErrors = str_replace('<LI>','', $_GET['errorMessage']);
  $formErrors = split('<br>',$formErrors);
  // print_r($formErrors);

  // Iterate Form Errors to compose Error Message HTML
  for($i = 0; $i < count($formErrors); $i++) {
    if(trim($formErrors[$i]) != '') {
      $errorMessage .= '<li>'. $formErrors[$i] .'.</li>';
    }
  }
}

// Set the field that the errors came from
if (isset($_GET['errorFields'])) {
  //print_r($_GET['errorFields']);
  $fields = explode(",", $_GET['errorFields']);
  foreach($fields as $errorField) {
    ${$errorField.Err} = "error";
  }
}

// Display any information the user already entered
if (isset($_GET['ordName'])){
  $_SESSION['user']['order']['ordName'] = $_GET['ordName'];
}

if (isset($_GET['ordPhoneNumber'])){
  $_SESSION['user']['order']['ordPhoneNumber'] = $_GET['ordPhoneNumber'];
}
if (isset($_GET['ordAddress1'])){
  $_SESSION['user']['order']['ordAddress1'] = $_GET['ordAddress1'];
}

if (isset($_GET['ordCity'])){
  $_SESSION['user']['order']['ordCity'] = $_GET['ordCity'];
}

if (isset($_GET['ordProvince'])){
  $_SESSION['user']['order']['ordProvince'] = $_GET['ordProvince'];
}

if (isset($_GET['ordCountry'])){
  $_SESSION['user']['order']['ordCountry'] = $_GET['ordCountry'];
}

if (isset($_GET['ordPostalCode'])){
  $_SESSION['user']['order']['ordPostalCode'] = $_GET['ordPostalCode'];
}

if (isset($_GET['ordEmailAddress'])){
  $_SESSION['user']['order']['ordEmailAddress'] = $_GET['ordEmailAddress'];
}

if (isset($_GET['trnCardOwner'])) {
  $_SESSION['user']['order']['trnCardOwner'] = $_GET['trnCardOwner'];
}

if (isset($_SESSION['user']['order']['ordProvince'])) {
  $prov = $_SESSION['user']['order']['ordProvince'];
}

// Required information for transactions
$merchant_id = "261220000";
$errorPage = "http://nes.breakerarts.com/checkout";
$BEANSTREAM_URL = "https://www.beanstream.com/scripts/process_transaction.asp";
$approvedPage = "http://nes.breakerarts.com/transaction";
$declinedPage = "http://nes.breakerarts.com/transaction";

// Order information
$trnAmount = "$".getCartSubTotal();
//$trnAmount = "$0.01";
$ordCountry = "CA";

// Credit Card Info
$trnCardOwner = "";
$trnCardNumber = "4030000010001234";
$trnExpMonth = "";
$trnExpYear = "";

?>

<h3>Your total is: <?= $trnAmount ?></h3>
<p>Complete the form below to checkout securely.</p>
<!-- Hidden variables -->
<form action="<?= $BEANSTREAM_URL; ?>" method="POST" name="payment_form" onclear="clearForm()" class="checkout">
  <input type="hidden" name="approvedPage" value="<?= $approvedPage; ?>" />
  <input type="hidden" name="declinedPage" value="<?= $declinedPage; ?>" />
  <input type="hidden" name="errorPage" value="<?= $errorPage; ?>" />
  <input type="hidden" name="trnAmount" value="<?= $trnAmount; ?>" />
  <input type="hidden" name="merchant_id" value="<?= $merchant_id; ?>" />
  <input type="hidden" name="ordCountry" value="<?= $ordCountry; ?>" />
  <!-- Billing information -->
  <div class="checkout-billing">
    <h3 title="Billing Address">Billing &amp; Shipping Address</h3>
    <label for="ordName" title="Name">Name: </label>
    <input type="text" name="ordName" id="ordName" value="<?= $_SESSION['user']['order']['ordName']; ?>" title="Name" maxlength="64" /><?= ($ordNameErr != '' ? '<span class="icon-warning"></span>':''); ?>
    <br />
    <label for="ordPhoneNumber" title="Phone Number">Phone Number: </label>
    <input type="text" name="ordPhoneNumber" id="ordPhoneNumber" value="<?= $_SESSION['user']['order']['ordPhoneNumber']; ?>" title="Phone Number" maxlength="32" /><?= ($ordPhoneNumberErr != '' ? '<span class="icon-warning"></span>':''); ?>
    <br />
    <label for="ordAddress1" title="Address">Address: </label>
    <input type="text" name="ordAddress1" id="ordAddress1" value="<?= $_SESSION['user']['order']['ordAddress1']; ?>" title="City" maxlength="64" /><?= ($ordAddress1Err != '' ? '<span class="icon-warning"></span>':''); ?>
    <br />
    <label for="ordCity" title="City">City: </label>
    <input type="text" name="ordCity" id="ordCity" value="<?= $_SESSION['user']['order']['ordCity']; ?>" title="City" maxlength="32" /><?= ($ordCityErr != '' ? '<span class="icon-warning"></span>':''); ?>
    <br />
    <label for="ordProvince" class="province" title="Province">Province: </label>
    <select name="ordProvince" id="ordProvince" title="Province">
      <option value="" selected="selected">-- Choose a Province --</option>
      <option value="AB"<?= ($prov == 'AB' ? ' selected="selected"':''); ?>>Alberta</option>
      <option value="BC"<?= ($prov == 'BC' ? ' selected="selected"':''); ?>>British Columbia</option>
      <option value="MB"<?= ($prov == 'MB' ? ' selected="selected"':''); ?>>Manitoba</option>
      <option value="NB"<?= ($prov == 'NB' ? ' selected="selected"':''); ?>>New Brunswick</option>
      <option value="NL"<?= ($prov == 'NL' ? ' selected="selected"':''); ?>>Newfoundland</option>
      <option value="NS"<?= ($prov == 'NS' ? ' selected="selected"':''); ?>>Nova Scotia</option>
      <option value="NT"<?= ($prov == 'NT' ? ' selected="selected"':''); ?>>Northwest Territories</option>
      <option value="NU"<?= ($prov == 'NU' ? ' selected="selected"':''); ?>>Nunavut</option>
      <option value="ON"<?= ($prov == 'ON' ? ' selected="selected"':''); ?>>Ontario</option>
      <option value="PE"<?= ($prov == 'PE' ? ' selected="selected"':''); ?>>Prince Edward Island</option>
      <option value="QC"<?= ($prov == 'QC' ? ' selected="selected"':''); ?>>Quebec</option>
      <option value="SK"<?= ($prov == 'SK' ? ' selected="selected"':''); ?>>Saskatchewan</option>
      <option value="YT"<?= ($prov == 'YT' ? ' selected="selected"':''); ?>>Yukon</option>
    </select>
    <?= ($ordProvinceErr != '' ? '<span class="icon-warning"></span>':''); ?><br />

    <label for="ordPostalCode" title="Postal Code">Postal Code: </label>
    <input type="text" name="ordPostalCode" id="ordPostalCode" value="<?= $_SESSION['user']['order']['ordPostalCode']; ?>" title="Postal Code" maxlength="16" />
    <?= ($ordPostalCodeErr != '' ? '<span class="icon-warning"></span>':''); ?><br />

    <label for="ordEmailAddress" title="Email Address">Email: </label>
    <input type="text" name="ordEmailAddress" id="ordEmailAddress" value="<?= $_SESSION['user']['order']['ordEmailAddress']; ?>" title="Email Address" maxlength="64" />
    <?= ($ordEmailAddressErr != '' ? '<span class="icon-warning"></span>':''); ?>
  </div>
  <div class="checkout-credit-card">
    <!-- Credit Cart Info -->
    <h3 title="Credit Card Information">Credit Card Information</h3>
    <label for="trnCardOwner" title="Cardholder's name">Name on card: </label>
    <input type="text" name="trnCardOwner" id="trnCardOwner" value="<?= $_SESSION['user']['order']['trnCardOwner']; ?>" title="Cardholder's name" maxlength="64" />
    <?= ($trnCardOwnerErr != '' ? '<span class="icon-warning"></span>':''); ?><br />

    <label for="trnCardNumber" title="Card Number">Card Number: </label>
    <input type="text" name="trnCardNumber" id="trnCardNumber" value="<?= $trnCardNumber; ?>" title="Card Number" maxlength="20" />
    <?= ($trnCardNumberErr != '' ? '<span class="icon-warning"></span>':''); ?><br />

    <label for="trnExpMonth" title="Expiry Date">Expiry Date MM/YY:  </label>
    <input type="text" name="trnExpMonth" id="trnExpMonth" class="expiry" value="<?= $trnExpMonth; ?>" size="2" maxlength="2" title="Expiry Month" />
    /
    <input type="text" name="trnExpYear" class="expiry" value="<?= $trnExpYear; ?>" size="2" maxlength="2" title="Expiry Year" /><?= (($trnExpYearErr != '' || $trnExpMonth != '') ? '<span class="icon-warning"></span>':''); ?><br />
  </div>
  <div class="clear"></div>
  <input type="submit" class="button-checkout" value="" />
  <a href="/checkout/?clear=yes" class="button-clear-form" title="Clear Form"></a>
</form>
<div class="clear"></div>
</div>

<?php
// Footer file for the page
include_once '../assets/php-footer.php';
?>
