<?php

//================================================================================================
// Initiate database connection
//================================================================================================
$dbConnectString = 'mysql:host=localhost;port=3306;dbname=kajes_linkify;charset=utf8';
$dbUser = 'root';
$dbPassword = '';

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
$registerUserQuery = <<<EOT
INSERT INTO users (name, email, password, bio, avatarID)
VALUES (:name, :email, :password, :bio, :avatarID)
EOT;

$registerUser = $dbConnection->prepare($registerUserQuery);

//================================================================================================
// User sign in
//================================================================================================
$loginQuery = <<<EOT
SELECT * FROM users
WHERE email = :email
LIMIT 1
EOT;

$userRow = $dbConnection->prepare($loginQuery);
