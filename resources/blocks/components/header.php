<header class="mainHeader">
  <h1><a href="/">LINKIFY</a></h1>
  <?php if ($currentUser) { ?>
    <section class="userMenu">
      <button class="userSettings">SETTINGS</button>
      <button class="newPost">NEW POST</button>
      <button type="submit" class="logout">LOG OUT</button>
    </section>
  <?php } else { ?>
    <button class="loginRegister">SIGN IN OR REGISTER</button>
  <?php }

    if (!$currentUser) {
      require_once 'authentication.php';
    } else {
      require_once 'userMenu.php';
    }

  ?>
</header>
