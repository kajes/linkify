<?php

require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  returnDie();
}

// Get the current user
$user = $dbConnection->query("SELECT * FROM users WHERE uid = {(int)$_SESSION['currentUser']} LIMIT 1")->fetch(PDO::FETCH_ASSOC);

$emailError = "You have not entered a valid email. Please check your email settings again.";

if (!isset($_POST['emailInput'])) {
  $_SESSION['emailError'] = $emailError;
  returnDie();
} elseif (!filter_var($_POST['emailInput'], FILTER_VALIDATE_EMAIL)) {
  $_SESSION['emailError'] = $emailError;
  returnDie();
}

// Check if user is trying to change password
if (isset($_POST['newPassword'])) {

  // Check if user has entered the old password field
  if (!isset($_POST['oldPassword'])) {
    $_SESSION['passwordError'] = "You need to verify password by typing in the current password before saving the new password.";
    returnDie();
  }

  // Check if old password field matches the current password
  if ($_POST['oldPassword'] !== password_verify($user['password'])) {
    $_SESSION['passwordError'] = "Wrong password. Please try again.";
    returnDie();
  }

}



//================================================================================================
// All fine so let's update user
//================================================================================================

// Assign variables
$email = (isset($_POST['emailInput']) ? $_POST['emailInput'] : $user['email']);
$password = (isset($_POST['newPassword'])) ? password_hash($_POST['newPassword'], PASSWORD_BCRYPT) : $user['password'];
$userBio = (isset($_POST['userBio']) ? $_POST['userBio'] : $user['bio'];

// Try to update user row with new information
try {
  $updateUser->execute([
    ':email' => $email,
    ':password' => $password,
    ':userBio' => $userBio,
    ':uid' => $user['uid']
  ]);
} catch (PDOException $e) {
  $_SESSION['updateUserError'] = "Failed to update account information. Please contact the site administrator.";
  logErrors($e->getMessage());
}
returnDie();
