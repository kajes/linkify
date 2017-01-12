<?php

require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /');
  die;
}

// die(var_dump(date('Y-m-d H:i:s')));
$response = [];

if (!validateFields([$_POST['postEdit'], $_POST['postID']])) {
  $response['error'] = "All required fields must be entered.";
  echo json_encode($response);
  die;
}

$postID = (int)$_POST['postID'];
$newContent = $_POST['postEdit'];
$postDate = date('Y-m-d H:i:s');

try {
  $postEdit->execute([
    ':post_content' => $newContent,
    ':updated_on' => $postDate,
    ':postID' => $postID
  ]);
  $response['message'] = "Post was updated successfully!";
} catch (PDOException $e) {
  $response['error'] = "Failed to edit post. Please contact admin.";
  echo json_encode($response);
  die;
}

$response['newPost'] = $dbConnection->query("SELECT * FROM posts WHERE postID = {$postID} LIMIT 1")->fetch(PDO::FETCH_ASSOC);

echo json_encode($response);
