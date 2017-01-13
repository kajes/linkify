<section class="mainContent">

  <?php
    if (!isset($_GET['postID'])) {
      require_once 'components/basePosts.php';
    } else {
      require_once 'components/singlePost.php';
    }
  ?>

</section>
