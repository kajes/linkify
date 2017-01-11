<?php

  // Get post based on GET request
  $postID = (int)$_GET['postID'];
  $post = $dbConnection->query("SELECT * FROM posts WHERE postID = {$postID}")->fetch(PDO::FETCH_ASSOC);

  // Get the user info about author
  $user = $dbConnection->query("SELECT * FROM users WHERE uid = {$post['authorID']} LIMIT 1")->fetch(PDO::FETCH_ASSOC);

  if ($user['avatarID'] !== NULL) {
    $avatar = $user['avatarID'].'.'.$user['avatarImageType'];
  } else {
    $avatar = '0.jpg';
  }

  // Get the number of comments on post
  $commentCount = count($dbConnection->query("SELECT * FROM posts WHERE parent_id = {$post['postID']}")->fetchAll());
  $hasComments = ($commentCount >= 1) ? true:false;

  // Format the date for each post
  $postDate = date('l jS \o\f F, Y', strtotime($post['posted_on']));
  $updateDate = date('l jS \o\f F, Y', strtotime($post['updated_on']));

?>
<section class="postContent">

<?php require 'post.php'; ?>

</section>
