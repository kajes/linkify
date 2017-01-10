<?php

require_once 'functions.php';

//================================================================================================
// Check for errors in field input request
//================================================================================================

// Check if user made post request, otherwise send back to landing page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  returnDie();
}

// Check if all registration fields are entered, else return to landing page and display error message
if (!validateFields([$_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'], $_POST['password_reenter']])) {
  $_SESSION['registerError'] = 'Please fill in all required fields.';
  returnDie();
}

// Validate email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  $_SESSION['registerError'] = 'The email adress you entered is not valid.';
  returnDie();
}

// Assign variables
$fullName = $_POST['firstName'].' '.$_POST['lastName'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordReenter = $_POST['password_reenter'];

// Check if email already exists in database
if ($dbConnection->query("SELECT email FROM users WHERE email = '{$email}' LIMIT 1")->fetch()) {
  $_SESSION['registerError'] = 'Email is already registered. Please try another email adress.';
  returnDie();
}

// Check if both password fields match
if ($password !== $passwordReenter) {
  $_SESSION['registerError'] = 'Password fields do not match. Please try again.';
  returnDie();
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
  logErrors($e->getMessage());
}

// Redirect back to landing page on success or failure
$_SESSION['currentUser'] = (int)$dbConnection->query("SELECT uid FROM users WHERE email = '{$email}' LIMIT 1")->fetch(PDO::FETCH_ASSOC)['uid'];
returnDie();
