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
// Register  and change user data
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

$userRow = $dbConnection->prepare($loginQuery);

// TODO: Queries for creating and updating posts and comments
