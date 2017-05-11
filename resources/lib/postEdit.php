<?php

require_once __DIR__.'/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    returnDie(false, 'Something went wrong when updating post. Please try again.');
}

if (!validateFields([$_POST['postEdit'], $_POST['postID']])) {
    returnDie(false, "All required fields must be entered.");
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
    returnDie(true, "Post was updated successfully!", $dbConnection->query("SELECT * FROM posts WHERE postID = {$postID} LIMIT 1")->fetch(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    returnDie(false, "Failed to edit post. Please contact admin.");
}
