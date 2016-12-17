<section class="mainContent">
  <?php
    if (!$currentUser) {
      require_once 'components/authentication.php';
    } else {
      require_once 'components/userMenu.php';
    }
  ?>
  <section class="postContent">
    <?php foreach ($postGet as $key => $post) { ?>
      <h3 class="postTitle"><?= $post['post_title']; ?></h3>
      <p class="postContent"><?= $post['post_content']; ?></p>
    <?php } ?>
  </section>
</section>
