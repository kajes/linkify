<?php

require_once 'database.php';

//================================================================================================
// Check user login status and start session
//================================================================================================
function checkLogin()
{
  session_start();

  // Check if user already authenticated with login form
  if (!isset($_SESSION['currentUser'])) {

    // Check if user has logged in before and has remember me cookie
    if (!isset($_COOKIE['kajes_linkify'])) {
      return false;
    }

  }

  return true;

}

//================================================================================================
// String escape and validation function
//================================================================================================
function validateString($string)
{
  return filter_var($string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}

//================================================================================================
// Validate and escape email
//================================================================================================
function validateEmail($email)
{
  return filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
}
