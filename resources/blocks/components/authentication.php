<section class="loginRegisterWrapper hide">
  <form action="/resources/lib/login.php" class="loginForm" method="POST">

    <h2>Sign in to Linkify</h2>

    <input type="text" class="login email" name="email" required placeholder="Email">

    <input type="password" class="login password" name="password" required placeholder="Password">

    <div class="rememberWrap">
      <input class="rememberMe" type="checkbox" name="rememberMe" value="1">
      <label for="rememberMe" class="label rememberMe">Remember me</label>
    </div>

    <input type="submit" class="login submit" value="Sign in">

  </form>

  <form action="resources/lib/register.php" class="registerForm" method="POST">

    <h2>Register here</h2>

    <input type="text" class="register firstName" name="firstName" required placeholder="First Name">

    <input type="text" class="register lastName" name="lastName" required placeholder="Last Name">

    <input type="email" class="register email" name="email" required placeholder="Email">

    <input type="password" class="register password" name="password" required placeholder="Password">

    <input type="password" class="register passwordReenter" name="password_reenter" required placeholder="Re-enter password">

    <input type="submit" class="register registerSubmit" value="Sign up">

  </form>
</section>
