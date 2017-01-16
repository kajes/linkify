<section class="newCommentWrap hide">
  <h2 class="settingsHeader">Comment on post</h2>
  <form class="newCommentForm" action="resources/lib/createPost.php" method="POST">
    <input type="hidden" name="parent_id" value="<?= $post['postID'] ?>">
    <textarea name="postContent" required></textarea>
    <input type="submit" name="createPostExecute" value="Comment">
    <?php
      if (isset($_SESSION['postError'])) {
        echo '<h5 class="error">'.$_SESSION['postError'].'</h5>';
        unset($_SESSION['postError']);
      }
    ?>
  </form>
</section>
