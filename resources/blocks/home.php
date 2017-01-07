<section class="mainContent">

  <?php
    if (!$currentUser) {
      require_once 'components/authentication.php';
    } else {
      require_once 'components/userMenu.php';
    }
  ?>

  <section class="postContent">

    <!-- Get all posts and comments in database and output in html -->
    <?php postDisplay($postGet); ?>

  </section>

</section>
