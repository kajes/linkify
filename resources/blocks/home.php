<section class="mainContent">
  <?php
    if (!$currentUser) {
      require_once 'components/authentication.php';
    } else {
      require_once 'components/userMenu.php';
    }

    require 'components/contentPresent.php';

  ?>
</section>
