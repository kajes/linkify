<?php

require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  returnDie();
}

// Get the current user
$user = $dbConnection->query("SELECT * FROM users WHERE uid = {$_SESSION['currentUser']} LIMIT 1")->fetch(PDO::FETCH_ASSOC);

$emailError = "You have not entered a valid email. Please check your email settings again.";

if (!isset($_POST['emailInput'])) {
  $_SESSION['emailError'] = $emailError;
  returnDie();
} elseif (!filter_var($_POST['emailInput'], FILTER_VALIDATE_EMAIL)) {
  $_SESSION['emailError'] = $emailError;
  returnDie();
}

// Check if user is trying to change password
if ($_POST['newPassword'] !== "") {

  // Check if user has entered the old password field
  if ($_POST['oldPassword'] === "") {
    $_SESSION['passwordError'] = "You need to verify password by typing in the current password before saving the new password.";
    returnDie();
  }

  // Check if old password field matches the current password
  if ($_POST['oldPassword'] !== password_verify($user['password'])) {
    $_SESSION['passwordError'] = "Wrong password. Please try again.";
    returnDie();
  }

}

// User avatar change
if ($_FILES['avatar']['name'] !== "") {

  $tmp = $_FILES['avatar']['tmp_name'];

  // Check if image type is valid
  if (!getImageContentType($tmp)) {
    $_SESSION['avatarError'] = "Invalid file type. Site only accepts jpg/jpeg or png files.";
    returnDie();
  }

  // Set size limit for image
  $size = getImageSize($tmp);
  if ($size[0] > 250 || $size[1] > 250) {
    $_SESSION['avatarError'] = "Image is too big. Max height and width is 250px.";
    returnDie();
  }

  $type = getImageContentType($tmp);
  $path = "../img/avatars/{$user['uid']}.$type";
  move_uploaded_file($tmp, $path);

}

//================================================================================================
// All fine so let's update user
//================================================================================================
// Assign variables
$email = ($_POST['emailInput'] !== "") ? $_POST['emailInput'] : $user['email'];
$newPassword = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
$password = ($_POST['newPassword'] !== "") ? $newPassword : $user['password'];
$userBio = ($_POST['userBio'] !== "") ? $_POST['userBio'] : NULL;
$imgExt = ($type) ? $type : NULL;

// Try to update user row with new information
try {
  $updateUser->execute([
    ':email' => $email,
    ':password' => $password,
    ':userBio' => $userBio,
    ':avatarID' => $user['uid'],
    ':avatarImageType' => $imgExt,
    ':uid' => $user['uid']
  ]);
} catch (PDOException $e) {
  $_SESSION['updateUserError'] = "Failed to update account information. Please contact the site administrator.";
  die($e->getMessage());
  logErrors($e->getMessage());
}
returnDie();
