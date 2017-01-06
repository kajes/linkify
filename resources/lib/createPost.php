<?php

require_once 'functions.php';

// Check if post request has been made, else send back to home
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /');
  die;
}

// Typecast the parentID because it makes sense
$parentID = (int)$_POST['parent_id'];

// Do check to see if post is comment or a base level post. Other fields are required depending on which
if ($parentID === 0) {
  // Check if all mandatory fields are entered, else send back with error
  if (!isset($_POST['postTitle']) || !isset($_POST['postContent'])) {
    $_SESSION['postError'] = 'All mandatory fields must be entered before publishing';
    header('Location: /');
    die;
  }
} elseif ($parentID < 0) {
  if (!isset($_POST['postContent'])) {
    $_SESSION['postError'] = 'All mandatory fields must be entered before publishing';
    header('Location: /');
    die;
  }
}

// All seems fine, so trying to input post into database
try {
  $createPost->execute([
    ':authorID' => $_SESSION['currentUser'],
    ':post_title' => $_POST['postTitle'],
    ':post_content' => $_POST['postContent'],
    ':posted_on' => date('Y-m-d H:i:s'),
    ':updated_on' => date('Y-m-d H:i:s'),
    ':parent_id' => $_POST['parent_id']
  ]);
} catch (PDOException $e) {
  $_SESSION['postError'] = 'Failed to publish post. Please contact the site administrator for help publishing post.';
  logErrors($e->getMessage());
}
header('Location: /');
die;
