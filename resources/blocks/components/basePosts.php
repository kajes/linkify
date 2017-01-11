<section class="postContent">

  <?php
    $posts = $dbConnection->query("SELECT * FROM posts WHERE parent_id = 0")->fetchAll(PDO::FETCH_ASSOC);

    foreach ($posts as $key => $post) {

      // Get user for each post
      $user = $dbConnection->query("SELECT * FROM users WHERE uid = {$post['authorID']} LIMIT 1")->fetch(PDO::FETCH_ASSOC);

      // Format the date for each post
      $postDate = date('l jS \o\f F, Y', strtotime($post['posted_on']));
      $updateDate = date('l jS \o\f F, Y', strtotime($post['updated_on']));

      // Count comments and set bool for comments
      $commentCount = count($dbConnection->query("SELECT * FROM posts WHERE parent_id = {$post['postID']}")->fetchAll());
      $hasComments = ($commentCount >= 1) ? true:false;

      // Set the avatar path
      if ($user['avatarID'] === NULL) {
        $avatar = '0.jpg';
      } else {
        $avatar = $user['avatarID'].'.'.$user['avatarImageType'];
      }

      require 'post.php';

    } // End Foreach

  ?>

</section>
