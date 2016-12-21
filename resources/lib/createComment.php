<?php

require_once 'functions.php';

// Check if post request has been made, else send back to home
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /');
  die;
}

// Check if all mandatory fields are entered, else send back with error
if (!isset($_POST['commentField']) && !isset($_POST['postID'])) {
  $_SESSION['postError'] = 'All mandatory fields must be entered before commenting';
  header('Location: /');
  die;
}

//================================================================================================
// All fine, let's input into database
//================================================================================================
try {
  $createComment->execute([
    ':parentID' => $_POST['postID'],
    ':authorID' => $_SESSION['currentUser'],
    ':content' => $_POST['commentField'],
    ':commentDate' => date('Y-m-d H:i:s'),
    ':editDate' => date('Y-m-d H:i:s')
  ]);
} catch (PDOException $e) {
  $_SESSION['commentError'] = 'Comment could not be created. Please contact site administrator.';
  logErrors($e->getMessage());
}
header('Location: /');
die;
