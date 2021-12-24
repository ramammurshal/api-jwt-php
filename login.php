<?php
  include("api/function.php");

  if (isset($_COOKIE["user_session"])) {
    header("Location: home.php");
    exit;
  }

  if (isset($_COOKIE["admin_session"])) {
    header("Location: home_admin.php");
    exit;
  }

  if (isset($_POST["login"])) {
    // jika admin
    if ($_POST["username"] === "ramz" || $_POST["username"] == "bilz") {
      if (login($_POST, "admin")) {
        header("Location: home_admin.php");
        exit;
      }
    }
    // jika user
    else {
      if (login($_POST, "user")) {
        header("Location: home.php");
        exit;
      }  
    }
    $errorLogin = true;
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <style>
    label {
      display: block;
    }

    input {
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <a href="index.php">< Kembali</a>

  <h2>Form login</h2>
  
  <?php if(isset($errorLogin)): ?>
    <p style="color: red;">Username atau password salah!</p>
  <?php endif; ?>

  <form action="" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br>

    <input type="submit" value="Submit" name="login" class="login">
  </form>

  <p>Belum punya akun? <a href="registrasi.php">Silahkan daftar disini</a></p>
</body>

</html>
