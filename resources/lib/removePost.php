<?php

require_once __DIR__.'/functions.php';

$output = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['currentUser']) || !isset($_POST['postID'])) {
    $output['error'] = "Request error.";
    echo json_encode($output);
    die;
}

$postID = (int)$_POST['postID'];
$user = (int)$_SESSION['currentUser'];

try {
    $postDelete->execute([
    ':postID' => $postID,
    ':user' => $user
  ]);

    $output['message'] = "Post was removed.";
} catch (PDOException $e) {
    $output['error'] = "An error occured while trying to remove post.";
    logErrors($e->getMessage());
}

echo json_encode($output);
