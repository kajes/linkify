<?php

require_once 'functions.php';

//================================================================================================
// Check for errors in field input request
//================================================================================================

// Check if user made post request, otherwise send back to landing page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../../');
  die();
}

// Check if all registration fields are entered, else return to landing page and display error message
if (!isset($_POST['fullName']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password_reenter'])) {
  $_SESSION['registerError'] = 'Please fill in all fields.';
  header('Location: ../../');
  die();
}

// Assign variables
$fullName = $_POST['fullName'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordReenter = $_POST['password_reenter'];

// Validate and escape all fields
$fullNameSanitized = filter_var($fullName, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_AMP);
$emailSanitized = validateEmail($email);
$passwordSanitized = validateString($password);
$passwordReenterSanitized = validateString($passwordReenter);

// Check if email already exists in database
if ($dbConnection->query("SELECT email FROM users WHERE email = '$emailSanitized' LIMIT 1")->fetch()) {
  $_SESSION['registerError'] = 'Email is already registered. Please try another email adress.';
  header('Location: ../../');
  die();
}

// Check if both password fields match
if ($passwordSanitized !== $passwordReenterSanitized) {
  $_SESSION['registerError'] = 'Password fields do not match. Please try again.';
  header('Location: ../../');
  die();
}

//================================================================================================
// All seems OK, so we can try registering the user
//================================================================================================
try {
  $registerUser->execute([
    ':name' => $fullNameSanitized,
    ':email' => $emailSanitized,
    ':password' => password_hash($passwordSanitized, PASSWORD_BCRYPT)
  ]);
} catch (PDOException $e) {
  $_SESSION['registerError'] = 'Failed to register user. Please contact the site administrator for help registering.';
  logErrors('../logs/errorlog.txt', $e->getMessage());
  header('Location: ../../');
  die();
}
header('Location: ..7..7');
die;
