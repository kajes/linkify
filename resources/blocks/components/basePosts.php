<section class="postContent">

  <?php

    $mainPosts->execute([
      ':parent' => 0,
      ':parentID' => 0
    ]);
    $posts = $mainPosts->fetchAll(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // die(var_dump($posts));
    // echo '</pre>';

    foreach ($posts as $key => $post) {

      // Format the date for each post
      $postDate = date('l jS \o\f F, Y', strtotime($post['postDate']));
      $updateDate = date('l jS \o\f F, Y', strtotime($post['updateDate']));

      $commentCount = $post['commentCount'];
      $hasComments = ($post['commentCount'] >= 1) ? true:false;

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
