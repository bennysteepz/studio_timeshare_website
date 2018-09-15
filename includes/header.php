<nav>
    <ul>
    <?php
    if (isset($_SESSION['user'])) {
      $ll = "Logout";
      if ($_SESSION['user'] != "manager") {
        ?>
        <li><a href="userhome.php">Book a Studio</a></li>
        <li><a href="mysessions.php">My Sessions</a></li>
        <?php
      }
    }
    else {
      $ll = "Login";
      ?>
      <li id="join"><a href="newaccount.php">Join</a></li>
      <?php
    }
    ?>
    <li id="logInOutNav"><a href="index.php"><?php echo $ll; ?></a></li>
    </ul>
</nav>
