<section class="loginRegisterWrapper">
  <form action="resources/lib/login.php" class="loginForm" method="POST">

    <h2>Sign in to Linkify:</h2>

    <input type="text" class="login email" name="email" required placeholder="Email">

    <input type="password" class="login password" name="password" required placeholder="Password">

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

    <input type="text" class="register firstName" name="firstName" required placeholder="First Name">

    <input type="text" class="register lastName" name="lastName" required placeholder="Last Name">

    <input type="email" class="register email" name="email" required placeholder="Email">

    <input type="password" class="register password" name="password" required placeholder="Password">

    <input type="password" class="register passwordReenter" name="password_reenter" required placeholder="Re-enter password">

    <input type="submit" class="register registerSubmit" value="Sign up">

    <?php
    if (isset($_SESSION['registerError'])) {
      echo '<h5 class="error">'.$_SESSION['registerError'].'</h5>';
      $_SESSION = [];
    }
    ?>

  </form>
</section>
