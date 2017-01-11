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
  // TODO: Check for accept header for json ajax
  // TODO: If accept header is json, return json errors

  if (strpos($_SERVER['HTTP_ACCEPT'], "application/json") !== FALSE) {
    # code...
  }

  header('Location: /');
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
function postDisplay($userQuery, $postQuery, $parentID=0, $level=0)
{

  // Get the base posts
  $postQuery->execute([
    ':parentID' => $parentID
  ]);
  $posts = $postQuery->fetchAll(PDO::FETCH_ASSOC);

  echo '<div class="comment child">';
  foreach ($posts as $key => $post) {

    // Get users from db
    $userQuery->execute([
      ':authorID' => $post['authorID']
    ]);
    $postAuthor = $userQuery->fetch(PDO::FETCH_ASSOC);

    // Author box
    $output = '<div class="authorBox">';
    $output .= '<img src="/resources/img/avatars/1.jpg" class="userAvatar" height="75px" width="75px">';
    $output .= '<p class="userName"><a href="/?userID='.$post['authorID'].'">'.$postAuthor['name'].'</a></p>';
    $output .= '</div>';

    // Vote Counter
    $output .=
    '<div class="voteBox">
      <i class="fa fa-thumbs-up voteUp" aria-hidden="true"></i>
      <h4 class="voteCount" data-postID="'.$post['postID'].'">'.$post['voteCount'].'</h4>
      <i class="fa fa-thumbs-down voteDown" aria-hidden="true"></i>
    </div>';

    // Output link text on base posts only
    if ($post['parent_id'] === '0') {
      $output .= '<h3>';

      // Output post title as link if link exists, else only output title
      if ($post['post_link'] !== NULL) {
        $output .= '<a href="'.$post['post_link'].'" target="_blank" rel="noopener">'.$post['post_title'].'</a>';
      } else {
        $output .= $post['post_title'];
      }

      $output .= '</h3>';
    }

    $output .= '<p>'.$post['post_content'].'</p>';

    // Render commenting field only if user is logged in
    if (isset($_SESSION['currentUser'])) {
      $output .= '<form class="newCommentForm" action="resources/lib/createPost.php" method="POST">';
      $output .= '<input type="hidden" name="parent_id" value="'.$post['postID'].'">';
      $output .= '<textarea name="postContent" required></textarea>';
      $output .= '<input type="submit" name="createCommentExecute" value="Comment">';

      if (isset($_SESSION['postError'])) {
        $output .= '<h5 class="error">'.$_SESSION['postError'].'</h5>';
        unset($_SESSION['postError']);
      }

      $output .= '</form>';


    } else {
      $output .= 'You must log in to comment. Log in or register <span class="loginLink">here</span>.';
    }

    echo $output;
    postDisplay($userQuery, $postQuery, $post['postID'], $level+1);

    echo "</div>";

  }

}
