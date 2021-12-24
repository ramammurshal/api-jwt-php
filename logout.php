<?php
  session_start();
  $_SESSION = [];
  session_unset();
  session_destroy();

  setcookie("user_session", 0, time()-1);
  setcookie("admin_session", 0, time()-1);
  setcookie("id", 0, time()-1);

  header("Location: index.php");
  exit;
?>
