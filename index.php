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
</body>
</html>
