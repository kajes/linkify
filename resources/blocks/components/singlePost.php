<?php

  // Get post based on GET request
  $postGetSingle->execute([
    ':postID' => (int)$_GET['postID']
  ]);
  $basePost = $postGetSingle->fetch(PDO::FETCH_ASSOC);

  // Get the user info about author
  $userGet->execute([
    ':authorID' => $basePost['authorID']
  ]);
  $user = $userGet->fetch(PDO::FETCH_ASSOC);

  // Format the date for each post
  $postDate = date('l jS \o\f F, Y', strtotime($basePost['posted_on']));
  $updateDate = date('l jS \o\f F, Y', strtotime($basePost['updated_on']));

?>
<section class="postContent">

  <div class="contentBox">
    <div class="authorBox">'
      <img src="/resources/img/avatars/1.jpg" class="userAvatar" height="75px" width="75px">'
      <p class="userName">By: <a href="/?userID='.$post['authorID'].'"><?= $user['name'] ?></a></p>
    </div>

    <div class="voteBox">

    </div>

    <div class="contentBox">
      <h2>
        <?php if ($basePost['post_link'] !== NULL) { ?>
          <a href="<?= $basePost['post_link'] ?>" target="_blank" rel="noopener"><?= $basePost['post_title'] ?></a>
          <span>(<a href="<?= $basePost['post_link'] ?>"><?= $basePost['post_link'] ?></a>)</span>
        <?php } else {
          echo $basePost['post_title'];
        } ?>
      </h2>
      <p><?= $basePost['post_content'] ?></p>
    </div>

    <div class="contentMetaBox">
      <span>Posted on: <?= $postDate ?></span>
      <span>By: <a href="/?userID=<?= $user['uid'] ?>"><?= $user['name'] ?></a></span>
      <?php if ($postDate !== $updateDate) { ?>
        <span>| Updated on: <?= $updateDate ?></span>
      <?php } ?>
    </div>

    <!-- Recurse to get all comments -->
    <?php postDisplay($userGet, $postGet, $basePost['postID']) ?>
  </div>

</section>
