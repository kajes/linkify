<section class="postContent">

  <?php

    $mainPosts->execute([
      ':parentID' => 0
    ]);
    $posts = $mainPosts->fetchAll(PDO::FETCH_ASSOC);

    foreach ($posts as $key => $post) {

      // Format the date for each post
      $postDate = date('Y-m-d', strtotime($post['postDate']));

        $commentCount = $post['commentCount'];
        $hasComments = ($commentCount >= 1) ? true:false;

      // Set the avatar path
      if ($post['avatarID'] === null) {
          $avatar = '0.jpg';
      } else {
          $avatar = $post['avatarID'].'.'.$post['imgType'];
      }

        require __DIR__.'/post.php';
    } // End Foreach

  ?>

</section>
