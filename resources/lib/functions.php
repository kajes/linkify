<?php

require_once 'database.php';

session_start();

//================================================================================================
// Log exception errors of unknown cause to log file
//================================================================================================
function logErrors($logPath, $error)
{
  $requestTime = date(c,$_SERVER['REQUEST_TIME']);
  $requestContent = $_POST ?? $_GET;
  $errorOrigin = $_SERVER['PHP_SELF'];

  $errorMessage = [
    $requestTime,
    $requestContent,
    $errorOrigin,
    $error
  ];

  file_put_contents($logPath, $errorMessage, FILE_APPEND);
}

//================================================================================================
// Check user login status
//================================================================================================
function checkLogin()
{

  // Check if user already authenticated with login form
  if (!isset($_SESSION['currentUser'])) {

    // Check if user has logged in before and has remember me cookie
    if (!isset($_COOKIE['kajes_linkify'])) {
      return false;
    }

  }

  $currentUser = $_SESSION['currentUser'];

  return $currentUser;

}

//================================================================================================
// String escape and validation function
//================================================================================================
function validateString($string)
{
  return filter_var($string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_ENCODE_AMP);
}

//================================================================================================
// Validate and escape email
//================================================================================================
function validateEmail($email)
{
  return filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
}

// TODO: Bake remember me cookie function
