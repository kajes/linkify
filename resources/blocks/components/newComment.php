<section class="newCommentWrap hide">
  <h2 class="settingsHeader">Comment on post</h2>
  <form class="newCommentForm" action="resources/lib/createPost.php" method="POST">
    <input type="hidden" class="commentParent" name="parent_id" value="<?= $_GET['postID']; ?>">
    <textarea class="commentContent" name="postContent" required></textarea>
    <input type="submit" class="commentSubmit" name="createPostExecute" value="Publish comment">
  </form>
</section>
