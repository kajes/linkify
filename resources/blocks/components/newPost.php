<section class="newPostWrap">
  <form class="newPostForm" action="resources/lib/createPost.php" method="POST">
    <input type="text" name="postTitle" placeholder="Title for your post" required>
    <textarea name="postContent" rows="8" cols="80" required></textarea>
    <input type="submit" name="createPostExecute" value="Publish post">
    <?php
      if (isset($_SESSION['postError'])) {
        echo '<h5 class="error">'.$_SESSION['postError'].'</h5>';
        unset($_SESSION['postError']);
      }
    ?>
  </form>
</section>
