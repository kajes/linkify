<?php

require_once __DIR__.'/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['currentUser'])) {
    returnDie(false, "You need to be logged in to vote");
}

if (!isset($_POST['vote']) || !in_array($_POST['vote'], ['1', '-1']) || !isset($_POST['postID'])) {
    returnDie(false, "Sum Ting Wong");
}

$userID = (int)$_SESSION['currentUser'];

// Prepare for db insert
$user = $dbConnection->query("SELECT * FROM users WHERE uid = {$userID} LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$post = $dbConnection->query("SELECT * FROM posts WHERE postID = {$_POST['postID']} LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$vote = (int)$_POST['vote'];
$postID = (int)$_POST['postID'];

$tmpArray = json_decode($user['votedOn']);

// Need to check if user already voted on this post
if (in_array($postID, $tmpArray)) {
    returnDie(false, "You can only vote on a post once");
}

$tmpArray[] = $postID;
$votedOn = json_encode($tmpArray);

try {
    $registerVote->execute([
    ':vote' => $vote,
    ':postID' => $postID,
    ':json' => $votedOn,
    ':uid' => $user['uid']
  ]);
} catch (PDOException $e) {
    returnDie(false, "Failed to register vote.");
    logErrors($e->getMessage());
}

returnDie(true, 'Vote was registered successfully', [ 'newCount' => (int)$dbConnection->query("SELECT voteCount FROM posts WHERE postID = {$postID} LIMIT 1")->fetch(PDO::FETCH_ASSOC)['voteCount']]);
