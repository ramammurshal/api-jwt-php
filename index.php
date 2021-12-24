<?php
  if (isset($_COOKIE["user_session"])) {
    header("Location: home.php");
    exit;
  }

  if (isset($_COOKIE["admin_session"])) {
    header("Location: home_admin.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>

<body>
  <h1>Welcome to index</h1>
  <h3>
    <a href="login.php">Login</a>
  </h3>
</body>
</html>
