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
if (!isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password_reenter'])) {
  $_SESSION['registerError'] = 'Please fill in all fields.';
  header('Location: ../../');
  die();
}

// Validate email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  $_SESSION['registerError'] = 'The email adress you entered is not valid.';
  header('Location: ../../');
  die();
}

// Assign variables and sanitize
$fullName = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING).' '.filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
$email = $_POST['email'];
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
$passwordReenter = filter_var($_POST['password_reenter'], FILTER_SANITIZE_STRING);

// Check if email already exists in database
if ($dbConnection->query("SELECT email FROM users WHERE email = '$email' LIMIT 1")->fetch()) {
  $_SESSION['registerError'] = 'Email is already registered. Please try another email adress.';
  header('Location: ../../');
  die();
}

// Check if both password fields match
if ($password !== $passwordReenter) {
  $_SESSION['registerError'] = 'Password fields do not match. Please try again.';
  header('Location: ../../');
  die();
}

//================================================================================================
// All seems OK, so we can try registering the user
//================================================================================================
try {
  $registerUser->execute([
    ':name' => $fullName,
    ':email' => $email,
    ':password' => password_hash($password, PASSWORD_BCRYPT)
  ]);
} catch (PDOException $e) {
  $_SESSION['registerError'] = 'Failed to register user. Please contact the site administrator for help registering.';
  logErrors('../logs/errorlog.txt', $e->getMessage());
}

// Redirect back to landing page on success or failure
header('Location: ../../');
die;
