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

  if ($user['avatarID'] !== NULL) {
    $avatar = $user['avatarID'].'.'.$user['avatarImageType'];
  } else {
    $avatar = '0.jpg';
  }

  // Format the date for each post
  $postDate = date('l jS \o\f F, Y', strtotime($basePost['posted_on']));
  $updateDate = date('l jS \o\f F, Y', strtotime($basePost['updated_on']));

?>
<section class="postContent">

  <div class="contentBox">
    <div class="authorBox">
      <img src="/resources/img/avatars/<?= $avatar ?>" class="userAvatar" height="75px" width="75px">
      <p class="userName">By: <a href="/?userID='<?= $basePost['authorID'] ?>"><?= $user['name'] ?></a></p>
    </div>

    <div class="voteBox">
      <i class="fa fa-thumbs-up voteUp" aria-hidden="true"></i>
      <h4 class="voteCount" data-postID="<?= $basePost['postID'] ?>"><?= $basePost['voteCount'] ?></h4>
      <i class="fa fa-thumbs-down voteDown" aria-hidden="true"></i>
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

    <form class="newCommentForm" action="resources/lib/createPost.php" method="POST">
      <input type="hidden" name="parent_id" value="<?= $basePost['postID'] ?>">
      <textarea name="postContent" required></textarea>
      <input type="submit" name="createCommentExecute" value="Comment">
      <?php if (isset($_POST['postError'])) { ?>
        <h5 class="error"><?= $_SESSION['postError'] ?></h5>
        <?php unset($_SESSION['postError']) ?>
      <?php } ?>
    </form>

    <!-- Recurse to get all comments -->
    <?php postDisplay($userGet, $postGet, $basePost['postID']) ?>
  </div>

</section>
