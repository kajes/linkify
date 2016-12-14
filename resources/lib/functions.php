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
    '--- START ---',
    $requestTime,
    $requestContent,
    $errorOrigin,
    $error,
    '--- END ---'
  ];

  file_put_contents($logPath, $errorMessage, FILE_APPEND);
}

//================================================================================================
// Bake remember me cookie
//================================================================================================
function bakeCookie($uid, $query)
{
  // Set cookie ingredients
  $first = bin2hex(random_bytes(64));
  $second = bin2hex(random_bytes(128));
  $cookie = "$first|$uid|$second";
  $timestamp = time() + 60 * 60 * 24 * 30;
  $expire = date('Y-m-d H:i:s', $timestamp);

  // Put in cookie oven
  try {
    $query->execute([
      ':uid' => $uid,
      ':first' => $first,
      ':second' => $second,
      ':expire' => $expire
    ]);
  } catch (PDOException $e) {
    logErrors('../../', $e->getMessage());
  }

  // Bake cookie in browser
  setcookie('kajes_linkify', $cookie, $timestamp, '/', '', false, true);

}

// TODO: Function for validating cookie

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

  return $_SESSION['currentUser'];

}
