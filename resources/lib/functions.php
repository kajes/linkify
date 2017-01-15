<?php

require_once 'database.php';

session_start();

//================================================================================================
// Log exception errors of unknown cause to log file
//================================================================================================
function logErrors($error)
{
  file_put_contents($_SERVER['DOCUMENT_ROOT']."resources/logs/errorlog.txt", $error."\n\n", FILE_APPEND);
}

//================================================================================================
// Return and error handling function
//================================================================================================
function returnDie()
{
  // Redirects back to the referer page
  header("Location: " . $_SERVER['HTTP_REFERER']);
  die;
}

//================================================================================================
// Required fields validation
//================================================================================================
function validateFields(array $array): bool
{
  if (in_array("", $array)) {
    return false;
  }

  return true;
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
// Validate and Get image content type function
//================================================================================================
function getImageContentType($image)
{
  // die(var_dump(exif_imagetype($image)));
  // if (exif_imagetype($image) !== 2 && exif_imagetype($image) !== 3) {
  if (!in_array(exif_imagetype($image), [2, 3])) {
    return false;
  } else {
    return (exif_imagetype($image) == 2) ? "jpg" : "png";
  }

}

//================================================================================================
// Recursive function for presenting posts and comments
//================================================================================================
function postDisplay($mainPosts, $parentID=0, $level=0)
{

  // Get the base posts
  $mainPosts->execute([
    ':parentID' => $parentID
  ]);
  $posts = $mainPosts->fetchAll(PDO::FETCH_ASSOC);

  echo '<div class="comment child">';
  foreach ($posts as $key => $post) {

    // Format the date for each post
    $postDate = date('jS \o\f F, Y', strtotime($post['postDate']));

    $commentCount = $post['commentCount'];
    $hasComments = ($commentCount >= 1) ? true:false;

    // User avatar url
    if ($post['avatarID'] === NULL) {
      $avatar = '0.jpg';
    } else {
      $avatar = $post['avatarID'].'.'.$post['imgType'];
    }

    require 'resources/blocks/components/post.php';

    if ($hasComments) {
      postDisplay($mainPosts, (int)$post['postID'], $level+1);
    }

  }
  echo "</div>";

}
