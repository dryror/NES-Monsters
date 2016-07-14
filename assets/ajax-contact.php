<?php

session_start();

$liveServer = 'true'; // Used for trouble shooting

// Error Handling vars
$errors = '';
$successMessage = '';
$fullnameError = '';
$emailFromError = '';
$messageError = '';

// Form vars
$fullname = trim($_REQUEST['n']);
$emailFrom = trim($_REQUEST['e']);
$message = trim($_REQUEST['m']);

// Validate Provided Email Domain
function domain_exists($email,$record = 'MX') {
  list($user,$domain) = split('@',$email);
  return checkdnsrr($domain,$record);
}

// Validate Email Address
function validateEmailAddress($email) {
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    return false;
  }
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",$local_array[$i])) {
      return false;
    }
  }
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) { return false; }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$",$domain_array[$i])) {
        return false;
      }
    }
  }
  if(domain_exists($email)) {
    return true;
  } else {
    return false;
  }
}

// Validate provided data
if($fullname == '') {
  $fullnameError = 'fail';
  $errors = 'error';
}
if($emailFrom == '') {
  $emailFromError = 'fail';
  $errors = 'error';
} else {
  if(!validateEmailAddress($emailFrom)) {
    $emailFromError = 'fail';
    $errors = 'error';
  }
}
if($message == '') {
  $messageError = 'fail';
  $errors = 'error';
}

if($errors == '') {
  // If on live server
  if($liveServer == 'true') {
    $to = 'rorydrysdale@gmail.com';
    $subject = 'NES Monsters Inquiry - '. $fullname;
    $inquiry = $message;
    $headers .= 'From: Admin <rorydrysdale@gmail.com>' . "\r\n";
    $headers .= 'Reply-To: '. $fullname .' <'. $emailFrom .'>'. "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    // Send Email
    if(mail("rorydrysdale@gmail.com", $subject, $inquiry))  {
      $successMessage = 'Your message has been sent.';
    } else {
      $successMessage = '';
      $emailFromError = 'fail';
    }
  } else {
    $successMessage = 'Your message has been sent.';
  }
} else {
  $successMessage = '';
}

echo '
{
  "results":
  {
    "emailSuccess":"'. $successMessage .'",
    "fullname":"'. $fullnameError .'",
    "emailAddress":"'. $emailFromError .'",
    "inquiry":"'. $messageError .'"
  }
}';

?>
