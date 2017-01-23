<?php

require_once __DIR__.'/functions.php';

//================================================================================================
// Check for errors in field input request
//================================================================================================

// Check if user made post request, otherwise send back to landing page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  returnDie(false, 'Failed to register user. Please try again.');
}

// Check if all registration fields are entered, else return to landing page and display error message
if (!validateFields([$_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'], $_POST['password_reenter']])) {
  returnDie(false, 'Please fill in all required fields.');
}

// Validate email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  returnDie(false, 'The email adress you entered is not valid.');
}

// Assign variables
$fullName = $_POST['firstName'].' '.$_POST['lastName'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordReenter = $_POST['password_reenter'];

// Check if email already exists in database
if ($dbConnection->query("SELECT email FROM users WHERE email = '{$email}' LIMIT 1")->fetch()) {
  returnDie(false, 'Email is already registered. Please try another email adress.');
}

// Check if both password fields match
if ($password !== $passwordReenter) {
  returnDie(false, 'Password fields do not match. Please try again.');
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
  $_SESSION['currentUser'] = (int)$dbConnection->query("SELECT uid FROM users WHERE email = '{$email}' LIMIT 1")->fetch(PDO::FETCH_ASSOC)['uid'];
  returnDie(true, "User register successful!");
} catch (PDOException $e) {
  returnDie(false, 'Failed to register user. Please contact the site administrator for help registering.');
  logErrors($e->getMessage());
}
