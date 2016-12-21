<section class="postContent">

  <!-- Get all posts in database and output in html -->
  <?php foreach ($postGet as $key => $post) {

      // Get the author of each post
      $userGet->execute([
        ':authorID' => $post['authorID']
      ]);
      $postAuthor = $userGet->fetch(PDO::FETCH_ASSOC);

      // Get all comments for post
      $commentGet->execute([
        ':postID' => $post['postID']
      ]);
      $postComment = $commentGet->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <!-- Output appropriate fields for each part of post -->
    <div class="postAuthorBox">
      <?php
        if ($postAuthor['avatarID'] !== NULL) {
          echo '<img src="/resources/img/avatars/'.$postAuthor['avatarID'].'.jpg" alt="'.$postAuthor['name'].'">';
        } else {
          echo '<img src="/resources/img/avatars/0.jpg" alt="'.$postAuthor['name'].'">';
        }
      ?>
      <span class="postedBy"><?= $postAuthor['name']; ?></span>
    </div>

    <h3 class="postTitle"><?= $post['post_title']; ?></h3>
    <p class="postContent"><?= $post['post_content']; ?></p>
    <div class="postVoteWrap">
      <a title="Vote Up" class="voteUp">Vote Up</a>
      <span class="voteCount"><?= $post['voteCount']; ?></span>
      <a title="Vote Down" class="voteDown">Vote Down</a>
    </div>

    <div class="postMeta">
      <span class="postedOn"><?= $post['posted_on']; ?></span>
      <?php if ($post['posted_on'] !== $post['updated_on']) { ?>
        <span class="updatedOn"><?= $post['updated_on']; ?></span>
      <?php } ?>
      <?php if (isset($_SESSION['currentUser']) && $_SESSION['currentUser'] === $post['authorID']) { ?>
        <span class="postEdit">Edit post</span>
      <?php } else { ?>
        <span class="postComment">Comment (<?= count($postComment); ?>)</span>
      <?php } ?>
    </div>

    <div class="postComment">
      <form action="/resources/lib/createComment.php" method="POST">
        <input type="hidden" name="postID" value="<?= $post['postID']; ?>">
        <textarea name="commentField"></textarea>
        <input type="submit" value="Submit Comment">
      </form>
      <?php
        if ($postComment) {
          echo "<h4>".$postComment[0]['content']."</h4>";
          // TODO: Proper way to display comments
          // renderComments($postComment);
        }
      ?>
    </div>

  <?php } ?>
</section>
