<form action="resources/lib/login.php" class="loginForm" method="POST">

  <h2>Sign in to Linkify:</h2>

  <h4 class="formLabel">Email:</h4>
  <input type="text" class="login email" name="email" required>

  <h4 class="formLabel">Password:</h4>
  <input type="password" class="login password" name="password" required>

  <label for="rememberMe">Remember me</label>
  <input type="checkbox" name="rememberMe" value="1">

  <input type="submit" class="login submit" value="Sign in">

  <?php
    if (isset($_SESSION['loginError'])) {
      echo '<h5 class="error">'.$_SESSION['loginError'].'</h5>';
      $_SESSION = [];
    }
  ?>

</form>

<form action="resources/lib/register.php" class="registerForm" method="POST">

  <h2>Register here:</h2>

  <h4 class="formLabel">Full name:</h4>
  <input type="text" class="register fullName" name="fullName" required>

  <h4 class="formLabel">Email:</h4>
  <input type="email" class="register email" name="email" required>

  <h4 class="formLabel">Password:</h4>
  <input type="password" class="register password" name="password" required>

  <h4 class="formLabel">Re-enter password</h4>
  <input type="password" class="register passwordReenter" name="password_reenter" required>

  <input type="submit" class="register registerSubmit" value="Sign up">

  <?php
    if (isset($_SESSION['registerError'])) {
      echo '<h5 class="error">'.$_SESSION['registerError'].'</h5>';
      $_SESSION = [];
    }
  ?>

</form>
