<section class="mainContent">

  <?php
    if (!isset($_GET['postID'])) {
      require_once 'components/basePosts.php';
    } else {
      if (!$dbConnection->query("SELECT * FROM posts WHERE postID = {$_GET['postID']} LIMIT 1")->fetch()) {
        header('Location: /');
      } else {
        require_once 'components/singlePost.php';
      }
    }
  ?>

</section>
