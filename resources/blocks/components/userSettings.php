<?php

  $user = $dbConnection->query("SELECT * FROM users WHERE uid = {$_SESSION['currentUser']}")->fetch(PDO::FETCH_ASSOC);

  $userBio = ($user['bio'] !== NULL) ? $user['bio'] : '';
  $avatar = ($user['avatarID'] !== NULL) ? $user['avatarID'].'.'.$user['avatarImageType'] : '0.jpg';

?>
<section class="userSettingsWrapper hide">

  <h2 class="settingsHeader">User Settings</h2>

  <form action="/resources/lib/userUpdate.php" class="settingsForm" method="POST" enctype="multipart/form-data">

    <div class="fieldset email">
      <label for="emailInput">Email:</label>
      <input type="email" name="emailInput" value="<?= $user['email'] ?>">
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
      <textarea name="userBio"><?= $userBio ?></textarea>
      <?php
        if (isset($_SESSION['bioError'])) {
          echo '<h5 class="error">'.$_SESSION['bioError'].'</h5>';
          unset($_SESSION['bioError']);
        }
      ?>
    </div>

    <div class="fieldset avatar">
      <label for="avatarInput">Change avatar:</label>
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
