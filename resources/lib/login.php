<?php

require_once 'functions.php';

//================================================================================================
// Check for errors on login request
//================================================================================================

// Check if user made post request, otherwise send back to landing page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  returnDie( false, "Something went wrong. Please try again.");
}

// Check if all required fields are entered, otherwise display errormessage
if (!validateFields([$_POST['email'], $_POST['password']])) {
  returnDie(false, 'Please enter all required fields.');
}

// Addign variables to form inputs and sanitize the password
$email = $_POST['email'];
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

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
  returnDie(false, 'Please enter all required fields.');
}

// Verify the password if user exists
if (!password_verify($password, $userData['password'])) {
  returnDie(false, $loginError);
}

// Bake cookie if remember me option is checked
if (isset($_POST['rememberMe'])) {
  bakeCookie($userData['uid'], $oven);
}

// Remember user in session and redirect to landing page
$_SESSION['currentUser'] = $userData['uid'];
returnDie(true, 'Welcome back '.$userData['name']);
