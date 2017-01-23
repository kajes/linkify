<?php

// Todo list
// TODO: Responsive site
// Extra features
// TODO: Reset password with email

?>

<?php

  // Get all the functions
  require_once __DIR__.'/resources/lib/functions.php';

  $currentUser = checkLogin($hand);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $pageTitle = 'HOME | Linkify';
    require_once __DIR__.'/resources/blocks/head.php';
  ?>
</head>
<body>
  <main class="mainWrapper">
    <?php
      require_once __DIR__.'/resources/blocks/components/header.php';

      require_once __DIR__.'/resources/blocks/home.php';

      require_once __DIR__.'/resources/blocks/components/footer.php';
    ?>
  </main>
  <script src="/resources/js/ajax.js" charset="utf-8"></script>
  <script src="/resources/js/main.js" charset="utf-8"></script>
</body>
</html>
