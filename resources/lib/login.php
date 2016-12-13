<?php

require_once 'functions.php';

//================================================================================================
// Check for errors on login request
//================================================================================================

// Check if user made post request, otherwise send back to landing page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../../');
  die();
}

// Check if all required fields are entered, otherwise display errormessage
if (!isset($_POST['email']) || !isset($_POST['password'])) {
  $_SESSION['loginError'] = 'Please enter all required fields.';
  header('Location: ../../');
  die();
}

// Validate login form fields
$validEmail = validateEmail($_POST['email']);
$validPassword = validateString($_POST['password']);

//================================================================================================
// All seems fine for actual login validation
//================================================================================================

// Save standard errormessage in variable
$loginError = 'Wrong email or password';

// Execute prepared query (see 32-41 in database)
$userVerify->execute([
  ':email' => $validEmail
]);
$userData = $userVerify->fetchAll(PDO::FETCH_ASSOC);

// Return error message if user does not exist
if (!$userData) {
  $_SESSION['loginError'] = $loginError;
  header('Location: ../../');
  die();
}

// FIXME: Password verification is not working :(
// Verify the password if user exists
if (!password_verify($validPassword, $userData[0]['password'])) {
  $_SESSION['loginError'] = $loginError;
  header('Location: ../../');
  die();
}

$_SESSION['currentUser'] = $userData[0]['uid'];
