<section class="postContent">

  <div>

    <?php
    $postGet->execute([
      ':parentID' => 0
    ]);
    $posts = $postGet->fetchAll(PDO::FETCH_ASSOC);

    foreach ($posts as $key => $post) {

      // Get user for each post
      $userGet->execute([
        ':authorID' => $post['authorID']
      ]);
      $user = $userGet->fetch(PDO::FETCH_ASSOC);

      // Format the date for each post
      $postDate = date('l jS \o\f F, Y', strtotime($post['posted_on']));
      $updateDate = date('l jS \o\f F, Y', strtotime($post['updated_on']));

      $postGet->execute([
        ':parentID' => $post['postID']
      ]);
      $commentCount = count($postGet->fetchAll());

      if ($user['avatarID'] === NULL) {
        $avatar = '/resources/img/avatars/0.jpg';
      } else {
        $avatar = '/resources/img/avatars/'.$user['avatarID'].'.'.$user['avatarImageType'];
      }

    ?>

      <div class="contentBox">
        <div class="authorBox">'
          <img src="<?= $avatar ?>" class="userAvatar" height="75px" width="75px">'
          <p class="userName">By: <a href="/?userID='.$post['authorID'].'"><?= $user['name'] ?></a></p>
        </div>

        <div class="voteBox">

        </div>

        <h2>
          <?php if ($post['post_link'] !== NULL) { ?>
            <a href="<?= $post['post_link'] ?>" target="_blank" rel="noopener"><?= $post['post_title'] ?></a>
            <span>(<a href="<?= $post['post_link'] ?>" target="_blank" rel="noopener"><?= $post['post_link'] ?></a>)</span>
          <?php } else {
            echo $post['post_title'];
          } ?>
        </h2>

        <p><?= $post['post_content'] ?></p>

        <div class="contentMetaBox">
          <span>Posted on: <?= $postDate ?></span>
          <?php if ($postDate !== $updateDate) { ?>
            <span>| Updated on: <?= $updateDate ?></span>
          <?php } ?>
          <p class="commentsLink"><a href="?postID=<?= $post['postID'] ?>"><?= $commentCount ?> Comments</a></p>
        </div>

      </div>

    <?php } // End Foreach ?>

  </div>

</section>
