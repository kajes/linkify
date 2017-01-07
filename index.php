<?php

// Todo list
// TODO: Edit account email, password and information
// TODO: Upload avatar
// TODO: Edit links and posts
// TODO: Delete links and posts
// TODO: Up and downvote posts

// Extra features
// TODO: Delete comments
// TODO: Reset password with email

?>

<?php
  // Get all the functions
  require_once 'resources/lib/functions.php';

  $currentUser = checkLogin($hand);
  // die(var_dump($_SESSION));

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $pageTitle = 'HOME | Linkify';
    require_once 'resources/blocks/head.php';
  ?>
</head>
<body>
  <main class="mainWrapper">
    <?php
      require_once 'resources/blocks/components/header.php';

      require_once 'resources/blocks/home.php';

      require_once 'resources/blocks/components/footer.php';
    ?>
  </main>
  <script src="resources/js/main.js" charset="utf-8"></script>
</body>
</html>
