<header class="mainHeader">


  <h1><a href="/"><img src="resources/img/link.png" alt="logo" class="linkLogo">LINKIFY</a></h1>

  <section class="userMenu">
  <?php if ($currentUser) {
    ?>
    <button class="userSettings">SETTINGS</button>
    <button class="newPost">NEW POST</button>
    <button type="submit" class="logout">LOG OUT</button>
  <?php 
} else {
    ?>
    <button class="loginRegister">SIGN IN OR REGISTER</button>
  <?php 
} ?>
  </section>

  <div class="errorMessageContainer hide">
    <h3 class="errorMessage"></h3>
  </div>
  <div class="messageSuccessContainer hide">
    <h3 class="messageSuccess"></h3>
  </div>

  <?php
    if (!$currentUser) {
        require_once __DIR__.'/authentication.php';
    } else {
        require_once __DIR__.'/userMenu.php';
    }

    if ($currentUser && isset($_GET['postID'])) {
        require __DIR__.'/newComment.php';
    }
  ?>


</header>
