<section class="newPostWrap hide">
  <h2 class="newPostHeader">NEW POST</h2>
  <form class="newPostForm" action="resources/lib/createPost.php" method="POST">
    <input type="hidden" class="parentID" name="parent_id" value="0">
    <input type="text" class="postTitle" name="postTitle" placeholder="Title" required>
    <input type="text" class="postLink" name="postLink" placeholder="Link here">
    <textarea name="postContent" class="postContent" required></textarea>
    <input type="submit" class="postSubmit" name="createPostExecute" value="Post">
  </form>
</section>
