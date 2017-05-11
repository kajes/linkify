<?php

  // Get post based on GET request
  $postID = (int)$_GET['postID'];
  $singlePost->execute([
    ':parent' => $postID,
    ':postID' => $postID
  ]);
  $post = $singlePost->fetch(PDO::FETCH_ASSOC);

  // Get the users avatar url
  if ($post['avatarID'] !== null) {
      $avatar = $post['avatarID'].'.'.$post['imgType'];
  } else {
      $avatar = '0.jpg';
  }

  // Get the number of comments on post
  $commentCount = $post['commentCount'];
  $hasComments = ($commentCount >= 1) ? true:false;

  // Format the date for each post
  $postDate = date('Y-m-d', strtotime($post['postDate']));
  $updateDate = date('Y-m-d', strtotime($post['updateDate']));

?>
<section class="postContent">

<?php require __DIR__.'/post.php'; ?>

</section>
