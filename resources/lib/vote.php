<?php

require_once 'functions.php';

// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//   header('Location: /');
//   die;
// }
//
// if (!isset($_POST['vote']) || !in_array($_POST['vote'], ['1', '-1']) || !isset($_POST['postID'])) {
//   $error = "Sum Ting Wong";
// }
//
// $vote = (int)$_POST['vote'];
// $postID = (int)$_POST['postID'];

$vote = (int)"-4";
$postID = (int)"15";

try {
  $registerVote->execute([
    ':vote' => $vote,
    ':postID' => $postID
  ]);
  echo "Vote registered";
} catch (PDOException $e) {
  echo "Failed to register vote.";
  // logErrors($e->getMessage());
}
