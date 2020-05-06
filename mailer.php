<?php

// For local debug
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
// header('Access-Control-Allow-Headers: token, Content-Type');
// header('Content-Type: application/json');

$name = '';
$email = '';
$msg = '';

$errors = [];

$isEmailSent = false;
$isEmptyContent = true;
$serverRes = 'Error: Unknown error. Please try again.';

// get request body
$req = file_get_contents('php://input');


if ($req !== '') {

  $decodedReq = json_decode($req, true);

  // get all values
  $name = htmlspecialchars($decodedReq['name']);
  $email = htmlspecialchars($decodedReq['email']);
  $msg = htmlspecialchars($decodedReq['message']);

  // Validation
  if (empty($name)) {
    array_push($errors, 'Name is a required field.');
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, 'This email address is not a valid email address.');
  }
  if (strlen($msg) < 20) {
    array_push($errors, 'Message must be more than 20 characters.');
  }
  if (preg_match('(:/|www)', $msg) === 1) {
    array_push($errors, 'Please remove a URL from your message for sending an inquiry.');
  }


  if (!empty($errors)) {
    // Error: Validation
    $errorMsg = implode(' ', $errors);
    $serverRes = "Error: $errorMsg";
    $isEmailSent = false;
    $isEmptyContent = false;
  } else {

    // Success
    mail('contact@tkusaka.com', "$name: Message from Contact Form", "This message is from $name ($email)\n --- \n $msg", "From: $email");
    $serverRes = "Thank you $name for getting in touch! I will reply to you at $email shortly.";
    $isEmailSent = true;
    $isEmptyContent = false;
  }

  echo json_encode(['isEmailSent' => $isEmailSent, 'isEmptyContent' => $isEmptyContent, 'serverRes' => $serverRes]);

} else if ($req === '') {
  // Error: Empty content or direct access
  $serverRes = 'Error: Empty content cannot be sent. Please try again.';
  echo json_encode(['isEmailSent' => $isEmailSent, 'isEmptyContent' => $isEmptyContent, 'serverRes' => $serverRes]);
  header('Location: http://tkusaka.com');
  die();
} else {
  // Error: Unknown
  echo json_encode(['isEmailSent' => $isEmailSent, 'isEmptyContent' => $isEmptyContent, 'serverRes' => $serverRes]);
}
