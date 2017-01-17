<?php

  if (isset($_SESSION['currentUser'])) {
    $user = $dbConnection->query("SELECT * FROM users WHERE uid = {$_SESSION['currentUser']}")->fetch(PDO::FETCH_ASSOC);

    $userBio = ($user['bio'] !== NULL) ? $user['bio'] : '';
    $avatar = ($user['avatarID'] !== NULL) ? $user['avatarID'].'.'.$user['avatarImageType'] : '0.jpg';
  }

?>
<section class="userSettingsWrapper hide">

  <h2 class="settingsHeader">User Settings</h2>

  <form action="/resources/lib/userUpdate.php" class="settingsForm" method="POST" enctype="multipart/form-data">

    <div class="fieldset email">
      <p class="label emailInput">New email:</p>
      <input type="email" name="emailInput" value="<?= $user['email'] ?>">
      <?php
        if (isset($_SESSION['emailError'])) {
          echo '<h5 class="error">'.$_SESSION['emailError'].'</h5>';
          unset($_SESSION['emailError']);
        }
      ?>
    </div>

    <div class="fieldset password">
      <p class="label newPassword">New password:</p>
      <input type="password" name="newPassword">
      <p class="label oldPassword">Old password:</p>
      <input type="password" name="oldPassword">
      <?php
        if (isset($_SESSION['passwordError'])) {
          echo '<h5 class="error">'.$_SESSION['passwordError'].'</h5>';
          unset($_SESSION['passwordError']);
        }
      ?>
    </div>

    <div class="fieldset userBio">
      <p class="label userBio">Biography:</p>
      <textarea name="userBio"><?= $userBio ?></textarea>
      <?php
        if (isset($_SESSION['bioError'])) {
          echo '<h5 class="error">'.$_SESSION['bioError'].'</h5>';
          unset($_SESSION['bioError']);
        }
      ?>
    </div>

    <div class="fieldset avatar">
      <p class="label avatarInput">Change avatar:</p>
      <input class="avatarUpload" type="file" name="avatar" hidden accept="image/jpeg image/png">
      <div class="placeholder avatar" id="avatarPlaceholder" style="background: url(/resources/img/avatars/<?= $avatar ?>) no-repeat center center; background-size: cover; height: 75px; width: 75px;"></div>
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
