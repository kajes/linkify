<?php

require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /');
  die;
}

$response = [];

if (!validateFields([$_POST['postEdit'], $_POST['postID']])) {
  $response['error'] = "All required fields must be entered.";
  echo json_encode($response);
  die;
}

try {
  $postEdit->execute([
    ':post_content' => $newContent,
    ':updated_on' => $postDate,
    ':postID' => $postID
  ])
  $response['message'] = "Post was updated successfully!";
} catch (PDOException $e) {
  $response['error'] = "Failed to edit post. Please contact admin.";
  echo json_encode($response);
  die;
}

echo json_encode($response);
