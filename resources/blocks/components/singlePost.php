<?php

  // Get post based on GET request
  $postID = (int)$_GET['postID'];
  $singlePost->execute([
    ':parent' => $postID,
    ':postID' => $postID
  ]);
  $post = $singlePost->fetch(PDO::FETCH_ASSOC);

  // Get the users avatar url
  if ($post['avatarID'] !== NULL) {
    $avatar = $post['avatarID'].'.'.$post['imgType'];
  } else {
    $avatar = '0.jpg';
  }

  // Get the number of comments on post
  $commentCount = $post['commentCount'];
  $hasComments = ($commentCount >= 1) ? true:false;

  // Format the date for each post
  $postDate = date('l jS \o\f F, Y', strtotime($post['postDate']));
  $updateDate = date('l jS \o\f F, Y', strtotime($post['updateDate']));

?>
<section class="postContent">

<?php require 'post.php'; ?>

</section>
