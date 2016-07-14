<?php
session_start();
include_once '../assets/php-header.php';

?>

<div class="content-inner">
  <h2 title="Contact">Contact</h2>
  <form action="#" method="post" name="contact-form" id="contact">
    <p>Contact the staff of NES Monsters.<br />All form fields are required.</p>
    <label for="fullname" id="fullLabel" title="Full Name">Full Name</label>
    <div class="form-input">
      <input type="text" name="fullname" id="fullname" value="" />
      <div class="warning hidden" id="e1"></div>
    </div>
    <div class="clear"></div>
    <label for="emailaddress" id="emailLabel" title="Email Address">Email Address</label>
    <div class="form-input">
      <input type="text" name="emailaddress" id="emailaddress" value="" />
      <div class="warning hidden" id="e2"></div>
    </div>
    <div class="clear"></div>
    <label for="inquiry" id="inquiryLabel" title="Inquiry">Inquiry</label>
    <div class="form-textarea">
      <textarea name="inquiry" id="inquiry"></textarea>
      <div class="warning hidden" id="e3"></div>
    </div>
    <div class="clear"></div>
    <label title="Are you human?">Are you human?</label>
    <noscript>JavaScript must be enabled to submit this form.</noscript>
    <div id="human-verification">
      <p id="pick"></p>
      <div id="cards"></div>
      <div class="hv-slot-frame" id="hv-slot-frame"><div id="hv-slot"></div></div>
      <div id="hv-feedback" class="feedback-unknown"></div>
    </div>
    <div class="clear">&nbsp;</div>
    <div id="submit" class="off" onclick="hv_submit();"></div>
  </form>
  <div class="contact-process hidden">Processing...</div>
  <div class="contact-success hidden">
    <h3>Your message has been sent.</h3>
    <div class="contact-thankyou" onclick="resetContact();"></div>
  </div>
</div>

<?php

include_once '../assets/php-footer.php';

?>
