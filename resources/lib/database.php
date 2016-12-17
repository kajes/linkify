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
  die($e->getMessage());
}

//================================================================================================
// Register and change user data
//================================================================================================
// TODO: More fields for bio and avatar
$registerUserQuery = <<<EOT
INSERT INTO users (name, email, password)
VALUES (:name, :email, :password)
EOT;

$registerUser = $dbConnection->prepare($registerUserQuery);

// TODO: Prepare query for user row update

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
INSERT INTO posts (authorID, post_title, post_content, posted_on, updated_on, comment_on)
VALUES (:authorID, :post_title, :post_content, :posted_on, :updated_on, :comment_on)
EOT;

$createPost = $dbConnection->prepare($postCreateQuery);

// TODO: Query for updating posts

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

//================================================================================================
// Query for getting posts and users
//================================================================================================
$postGet = $dbConnection->query("SELECT * FROM posts ORDER BY posted_on DESC")->fetchAll(PDO::FETCH_ASSOC);

$userGet = $dbConnection->prepare("SELECT * FROM users WHERE uid = :authorID LIMIT 1");
