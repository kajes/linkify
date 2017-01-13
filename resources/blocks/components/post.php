<div class="contentBox">

  <div class="voteBox">
    <i class="fa fa-thumbs-up voteUp" aria-hidden="true"></i>
    <h4 class="voteCount" data-postID="<?= $post['postID'] ?>"><?= $post['voteCount'] ?></h4>
    <i class="fa fa-thumbs-down voteDown" aria-hidden="true"></i>
  </div>

  <div class="authorBox">
    <img src="/resources/img/avatars/<?= $avatar ?>" class="userAvatar" height="75px" width="75px">
    <p class="userName">By: <a href="/?userID='.$post['authorID'].'"><?= $user['name'] ?></a></p>
  </div>

  <h2 class="postTitle">
    <?php if ($post['post_link'] !== NULL) { ?>
      <a href="<?= $post['post_link'] ?>" target="_blank" rel="noopener"><?= $post['post_title'] ?></a>
      <p>(<a href="<?= $post['post_link'] ?>" target="_blank" rel="noopener"><?= $post['post_link'] ?></a>)</p>
    <?php } else {
      echo $post['post_title'];
    } ?>
  </h2>

  <p id="id-<?= $post['postID'] ?>" class="postContent"><?= $post['post_content'] ?></p>

  <div class="contentMetaBox">
    <span>Posted on: <?= $post['posted_on'] ?></span>

    <?php if ($post['posted_on'] !== $post['updated_on']) { ?>
      <span>| Updated on: <?= $post['updated_on'] ?></span>
    <?php } ?>

    <p class="commentsLink"><a href="?postID=<?= $post['postID'] ?>"><?= $commentCount ?> Comments</a></p>

    <?php if (isset($_SESSION['currentUser']) && $user['uid'] === $_SESSION['currentUser']) { ?>
      <?php // TODO: Post edit and delete here ?>
      <button class="button postEdit" data-postid="<?= $post['postID'] ?>">Edit post</button>
      <button class="button postRemove" data-postid="<?= $post['postID'] ?>">Remove post</button>
    <?php } ?>

    <?php
    if (isset($_SESSION['currentUser']) && isset($_GET['postID'])) {
      require 'newComment.php';
    }
    ?>

  </div>

  <?php
    if (isset($_GET['postID']) && $_GET['postID'] === $post['postID'] && $hasComments) {
      postDisplay($dbConnection, (int)$post['postID']);
    }
  ?>

</div>
