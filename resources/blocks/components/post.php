<div class="contentBox">

  <div class="voteBox">
    <div class="voteThumb voteUp" alt="voteUp"></div>
    <div class="voteThumb voteDown" alt="voteDown"></div>
  </div>

  <div class="postContainer">

      <h2 class="postTitle">
        <?php
        if ($post['link'] !== '') {
            echo '<a href="'.$post['link'].'" target="_blank" rel="noopener">'.$post['title'].'</a>';
        } else {
            echo $post['title'];
        }
        ?>
      </h2>
      <?php
      if ($post['link'] !== '') {
          $parsedUrl = parse_url($post['link'], PHP_URL_HOST);
          echo '<small class="postLink">(<a href="'.$post['link'].'" target="_blank" rel="noopener">'.$parsedUrl.'</a>)</small>';
      }
      ?>
      <p id="id-<?= $post['postID'] ?>" class="postContent"><?= $post['content'] ?></p>

      <?php if (isset($_SESSION['currentUser']) && $post['userID'] === $_SESSION['currentUser']) {
          ?>
        <button class="button postEdit" data-postid="<?= $post['postID'] ?>">Edit post</button>
        <button class="button postRemove" data-postid="<?= $post['postID'] ?>">Remove post</button>
      <?php 
      } ?>

  </div>

  <div class="authorBox">
    <img src="resources/img/avatars/<?= $avatar ?>" alt="<?= $post['author']; ?>" class="userAvatar">
  </div>

  <h4 class="voteCount" data-postID="<?= $post['postID'] ?>"><?= $post['voteCount'] ?></h4>
  <div class="contentMetaBox">
    <span class="postDate"><?= $postDate ?></span>

    <span class="commentsLink"><a href="?postID=<?= $post['postID'] ?>"><?= $commentCount ?> Comments</a></span>

    <span class="authorName">By: <?= $post['author'] ?></span>

    <?php if ($post['postDate'] !== $post['updateDate']) {
          ?>
      <span>(edited)</span>
    <?php 
      } ?>

    <?php if (isset($_SESSION['currentUser']) && isset($_GET['postID'])) {
          ?>
      <button class="callToAction">Say something about this!</button>
    <?php 
      } ?>
  </div>

  <?php
    if (isset($_GET['postID']) && $_GET['postID'] === $post['postID'] && $hasComments) {
        commentDisplay($mainPosts, (int) $post['postID']);
    }
  ?>

</div>
