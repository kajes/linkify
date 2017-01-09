<?php

  $userGet->execute([':authorID' => (int)$_SESSION['currentUser']]);
  $user = $userGet->fetch(PDO::FETCH_ASSOC);

  if ($user['avatarID'] === NULL) {
    $avatar = '/resources/img/avatars/0.jpg';
  } else {
    $avatar = '/resources/img/avatars/'.$user['avatarID'].'.jpg';
  }

?>
<section class="userSettingsWrapper">

  <h2 class="settingsHeader">User Settings</h2>

  <form action="/resources/lib/userUpdate.php" class="settingsForm" method="POST" enctype="multipart/form-data">

    <div class="fieldset email">
      <label for="emailInput">Email:</label>
      <input type="email" name="emailInput">
      <?php
        if (isset($_SESSION['emailError'])) {
          echo '<h5 class="error">'.$_SESSION['emailError'].'</h5>';
          unset($_SESSION['emailError']);
        }
      ?>
    </div>

    <div class="fieldset password">
      <label for="newPassword">New password:</label>
      <input type="password" name="newPassword">
      <label for="oldPassword">Old password:</label>
      <input type="password" name="oldPassword">
      <?php
        if (isset($_SESSION['passwordError'])) {
          echo '<h5 class="error">'.$_SESSION['passwordError'].'</h5>';
          unset($_SESSION['passwordError']);
        }
      ?>
    </div>

    <div class="fieldset userBio">
      <label for="userBio">Biography:</label>
      <textarea name="userBio"></textarea>
      <?php
        if (isset($_SESSION['passwordError'])) {
          echo '<h5 class="error">'.$_SESSION['bioError'].'</h5>';
          unset($_SESSION['bioError']);
        }
      ?>
    </div>

    <div class="fieldset avatar">
      <label for="avatarInput">Change avatar:</label>
      <input type="file" name="avatar" accept="image/jpeg image/png">
      <div class="placeholder avatar" id="avatarPlaceholder" style="background: url(<?= $avatar ?>) no-repeat center center; background-size: cover;"></div>
      <?php
        if (isset($_SESSION['avatarError'])) {
          echo '<h5 class="error">'.$_SESSION['avatarError'].'</h5>';
          unset($_SESSION['avatarError']);
        }
      ?>
    </div>

    <input type="submit" value="Save settings">
  </form>

</section>
