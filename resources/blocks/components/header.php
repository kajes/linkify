<header class="mainHeader">

  <h1><a href="/">LINKIFY</a></h1>

  <section class="userMenu">
  <?php if ($currentUser) { ?>
    <button class="userSettings">SETTINGS</button>
    <button class="newPost">NEW POST</button>
    <button type="submit" class="logout">LOG OUT</button>
  <?php } else { ?>
    <button class="loginRegister">SIGN IN OR REGISTER</button>
  <?php } ?>
  </section>

  <?php
    if (!$currentUser) {
      require_once 'authentication.php';
    } else {
      require_once 'userMenu.php';
    }

    if ($currentUser && isset($_GET['postID'])) {
      require 'newComment.php';
    }
  ?>


</header>
