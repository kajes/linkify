<?php

//================================================================================================
// Initiate database connection
//================================================================================================
$dbConnectString = 'mysql:host=localhost;port=3306;dbname=kajes_linkify;charset=utf8';
$dbUser = 'root';
$dbPassword = '';
// FIXME: Change db user to something else than root

try {
  $dbConnection = new PDO($dbConnectString, $dbUser, $dbPassword);
  $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo '<h1 style="text-align: center;">Unable to connect to database.</h1>';
  file_put_contents($_SERVER['DOCUMENT_ROOT']."resources/logs/errorlog.txt", $e->getMessage()."\n", FILE_APPEND);
}

//================================================================================================
// Register and change user data
//================================================================================================
$registerUserQuery = <<<EOT
INSERT INTO users (name, email, password)
VALUES (:name, :email, :password)
EOT;

$registerUser = $dbConnection->prepare($registerUserQuery);

$updateUserQuery = <<<EOT
UPDATE users
SET email = :email, password = :password, bio = :userBio, avatarID = :avatarID, avatarImageType = :avatarImageType
WHERE uid = :uid
EOT;

$updateUser = $dbConnection->prepare($updateUserQuery);

//================================================================================================
// User sign in
//================================================================================================
$loginQuery = <<<EOT
SELECT * FROM users
WHERE email = :email
LIMIT 1
EOT;

$userVerify = $dbConnection->prepare($loginQuery);

//================================================================================================
// Post create and update prepares
//================================================================================================
$postCreateQuery = <<<EOT
INSERT INTO posts (authorID, post_title, post_link, post_content, posted_on, updated_on, parent_id)
VALUES (:authorID, :post_title, :post_link, :post_content, :posted_on, :updated_on, :parent_id)
EOT;

$createPost = $dbConnection->prepare($postCreateQuery);

$postEditQuery = <<<EOT
UPDATE posts
SET post_content = :post_content, updated_on = :updated_on
WHERE postID = :postID
EOT;

$postEdit = $dbConnection->prepare($postEditQuery);

//================================================================================================
// Voting update
//================================================================================================
$voteQuery = <<<EOT
UPDATE posts
SET voteCount = voteCount + (:vote)
WHERE postID = :postID
EOT;

$registerVote = $dbConnection->prepare($voteQuery);

//================================================================================================
// Prepare ingredients for baking cookie
//================================================================================================
$bowl = <<<EOT
INSERT INTO tokens (uid, first, second, expire)
VALUES (:uid, :first, :second, :expire)
EOT;

$oven = $dbConnection->prepare($bowl);

//================================================================================================
// Set table for eating cookie
//================================================================================================
$plate = <<<EOT
SELECT * FROM tokens
WHERE uid = :uid
AND first = :first
AND second = :second
LIMIT 1
EOT;

$hand = $dbConnection->prepare($plate);
