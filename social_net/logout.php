  <?php
  session_start();
  session_destroy();
  echo "You have successfully logged out..<a href='home.php'>Click here </a>to login again..! ";
  header("loaction: home.php");
  ?>