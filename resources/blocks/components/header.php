<header class="mainHeader">
  <h1><a href="/">Linkify</a></h1>
  <?php if ($currentUser) { ?>
    <section class="userMenu">
      <button class="newPost">New post</button>
      <button class="userSettings">Settings</button>
      <form action="resources/lib/logout.php" method="POST">
        <input type="submit" value="Log Out" class="logout">
      </form>
    </section>
  <?php } else { ?>
    <button class="loginRegister">Sign in or register</button>
  <?php } ?>
</header>
