<header class="mainHeader">
  <h1>Linkify</h1>
  <?php if ($currentUser) { ?>
    <section class="userMenu">
      <form action="resources/lib/logout.php" method="POST">
        <input type="submit" value="Log Out" class="logout">
      </form>
    </section>
  <?php } ?>
</header>
