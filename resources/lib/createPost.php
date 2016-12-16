<?php

require_once 'functions.php';

// Check if post request has been made, else send back to home
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../../');
  die;
}

// Check if all mandatory fields are entered, else send back with error
if (!isset($_POST['postTitle']) || !isset($_POST['postContent'])) {
  $_SESSION['postError'] = 'All mandatory fields must be entered before publishing';
  header('Location: ../../');
  die;
}

// Do check to see if post is comment on other post
$checkComment = $_SESSION['isComment'] ?? NULL;

// All seems fine, so trying to input post into database
try {
  $createPost->execute([
    ':authorID' => $_SESSION['currentUser'],
    ':post_title' => $_POST['postTitle'],
    ':post_content' => $_POST['postContent'],
    ':posted_on' => date('Y-m-d H:i:s'),
    ':updated_on' => date('Y-m-d H:i:s'),
    ':comment_on' => $checkComment
  ]);
} catch (PDOException $e) {
  $_SESSION['postError'] = 'Failed to publish post. Please contact the site administrator for help publishing post.';
  logErrors('../logs/errorlog.txt', $e->getMessage());
}
header('Location: ../../');
die;
