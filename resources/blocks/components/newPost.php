<section class="newPostWrap hide">
  <h2 class="newPostHeader">NEW POST</h2>
  <form class="newPostForm" action="resources/lib/createPost.php" method="POST">
    <input type="hidden" name="parent_id" value="0">
    <input type="text" name="postTitle" placeholder="Title" required>
    <input type="text" name="postLink" placeholder="Link here">
    <textarea name="postContent" required></textarea>
    <input type="submit" name="createPostExecute" value="Post">
    <?php
      if (isset($_SESSION['postError'])) {
        echo '<h5 class="error">'.$_SESSION['postError'].'</h5>';
        unset($_SESSION['postError']);
      }
    ?>
  </form>
</section>
