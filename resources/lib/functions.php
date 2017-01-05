<?php

require_once 'database.php';

session_start();

//================================================================================================
// Log exception errors of unknown cause to log file
//================================================================================================
function logErrors($error)
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

  file_put_contents('/resources/logs/errorlog.txt', $errorMessage, FILE_APPEND);
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
    logErrors('/', $e->getMessage());
  }

  // Bake cookie in browser
  setcookie('kajes_linkify', $cookie, $timestamp, '/', '', false, true);

}

//================================================================================================
// Function for eating (validating) cookie
//================================================================================================
function eatCookie($query)
{
  $values = explode('|', $_COOKIE['kajes_linkify']);

  $query->execute([
    ':uid' => $values[1],
    ':first' => $values[0],
    ':second' => $values[2]
  ]);
  $entry = $query->fetch(PDO::FETCH_ASSOC);

  if (!$entry || $entry['expire'] < date('Y-m-d H:i:s')) {
    return false;
  }

  return $entry['uid'];

}


//================================================================================================
// Check user login status
//================================================================================================
function checkLogin($query)
{

  // Check if user already authenticated with login form
  if (!isset($_SESSION['currentUser'])) {

    // Check if user has logged in before and has remember me cookie
    if (!isset($_COOKIE['kajes_linkify'])) {
      return false;
    }

    // Return value of eatCookie function if cookie exists
    return eatCookie($query);

  }

  // Return uid if session variable is set
  return $_SESSION['currentUser'];

}

//================================================================================================
// Recursive function for presenting posts and comments
//================================================================================================
function postDisplay($postQuery, $parentID=0, $level=0)
{
  // Get the base posts
  $postQuery->execute([
    ':parentID' => $parentID
  ]);
  $posts = $postQuery->fetchAll(PDO::FETCH_ASSOC);

  echo "<ul>";
  foreach ($posts as $key => $post) {
    $output = "<li>";
    $output .= '<h4>'.$post['post_title'].'</h4>';
    $output .= '<p>'.$post['post_content'].'</p>';
    $output .= "</li>";
    echo $output;
    postDisplay($postQuery, $post['postID'], $level+1);
  }
  echo "</ul>";

}
