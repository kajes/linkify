<?php

require_once 'functions.php';

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
$fullNameSanitized = validateString($fullName);
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
