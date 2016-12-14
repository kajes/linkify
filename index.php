<?php
  // Get all the functions
  require_once 'resources/lib/functions.php';

  $currentUser = checkLogin();
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

      echo '<section class="mainContent">';
      if (!$currentUser) {
        require_once 'resources/blocks/authentication.php';
      } else {
        require_once 'resources/blocks/home.php';
      }
      echo '</section>';

      require_once 'resources/blocks/components/footer.php';
    ?>
  </main>
</body>
</html>
