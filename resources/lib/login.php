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
$email = $_POST['email'];
$password = $_POST['password'];

//================================================================================================
// All seems fine for actual login validation
//================================================================================================

// Save standard errormessage in variable
$loginError = 'Wrong email or password';

// Execute prepared query (see 32-41 in database)
$userVerify->execute([
  ':email' => $email
]);
$userData = $userVerify->fetch(PDO::FETCH_ASSOC);

// Return error message if user does not exist
if (!$userData) {
  $_SESSION['loginError'] = $loginError;
  header('Location: ../../');
  die();
}

// Verify the password if user exists
if (!password_verify($password, $userData[0]['password'])) {
  $_SESSION['loginError'] = $loginError;
  header('Location: ../../');
  die();
}

// Bake cookie if remember me option is checked
if (isset($_POST['rememberMe'])) {
  bakeCookie($userData[0]['uid'], $oven);
}

// Remember user in session and redirect to landing page
$_SESSION['currentUser'] = $userData[0]['uid'];
header('Location: ../../');
die;
