<?php

require_once 'functions.php';

// Check if post request has been made, else send back to home
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  returnDie(false, "Something went wrong. Please try again.");
}

// Typecast the parentID because it makes sense
$parentID = (int)$_POST['parent_id'];

// Do check to see if post is comment or a base level post. Other fields are required depending on which
if ($parentID === 0) {
  // Check if all mandatory fields are entered, else send back with error
  if (!validateFields([$_POST['postTitle'], $_POST['postContent']])) {
    returnDie(false, 'All required fields must be entered before publishing');
  }
} elseif ($parentID <= 1) {
  if (!validateFields([$_POST['postContent']])) {
    returnDie(false, 'All required fields must be entered before publishing');
  }
}

// Need to set the postlink to a value so it doesn't get saved as an empty string in db if it's empty
$postLink = (isset($_POST['postLink'])) ? $_POST['postLink'] : NULL;
$postTitle = (isset($_POST['postTitle'])) ? $_POST['postTitle'] : NULL;

// All seems fine, so trying to input post into database
try {
  $createPost->execute([
    ':authorID' => $_SESSION['currentUser'],
    ':post_title' => $postTitle,
    ':post_link' => $postLink,
    ':post_content' => $_POST['postContent'],
    ':posted_on' => date('Y-m-d H:i:s'),
    ':updated_on' => date('Y-m-d H:i:s'),
    ':parent_id' => $_POST['parent_id']
  ]);
  $lastID = $dbConnection->lastInsertId();
  $content = $dbConnection->query("SELECT * FROM posts WHERE postID = {$lastID}")->fetch(PDO::FETCH_ASSOC);
  returnDie(true, 'Post was published succesfully! Waiting for page reload.', $content);
} catch (PDOException $e) {
  returnDie(false, 'Failed to publish post. Please contact the site administrator for help publishing post.');
  logErrors($e->getMessage());
}
