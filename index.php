<?php

// Todo list
// TODO: Edit links and posts
// TODO: Delete links and posts

// Extra features
// TODO: Delete comments
// TODO: Reset password with email

?>

<?php

  // Get all the functions
  require_once 'resources/lib/functions.php';

  $currentUser = checkLogin($hand);

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
  <script src="/resources/js/main.js" charset="utf-8"></script>
</body>
</html>
