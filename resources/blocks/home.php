<section class="mainContent">

  <?php
    if (!$currentUser) {
      require_once 'components/authentication.php';
    } else {
      require_once 'components/userMenu.php';
    }

    if (!isset($_GET['postID'])) {
      require_once 'components/basePosts.php';
    } else {
      require_once 'components/singlePost.php';
    }
  ?>

</section>
