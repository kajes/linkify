<?php

require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /');
  die;
}

$output = [];

if (!isset($_POST['vote']) || !in_array($_POST['vote'], ['1', '-1']) || !isset($_POST['postID'])) {
  $output['error'] = "Sum Ting Wong";
}

$vote = (int)$_POST['vote'];
$postID = (int)$_POST['postID'];

try {
  $registerVote->execute([
    ':vote' => $vote,
    ':postID' => $postID
  ]);
} catch (PDOException $e) {
  $output['error'] = "Failed to register vote.";
  logErrors($e->getMessage());
}

$output['newCount'] = (int)$dbConnection->query("SELECT voteCount FROM posts WHERE postID = {$postID} LIMIT 1")->fetch(PDO::FETCH_ASSOC)['voteCount'];

echo json_encode($output);
