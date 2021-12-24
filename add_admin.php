<?php
  include("api/connection.php");
  if (isset($_POST["register"])) {
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = mysqli_query($connect, "INSERT INTO admin VALUES('', '$username', '$password')");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Add admin</h1>
<form action="" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" class="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" class="password1" required><br>
    
    <input type="submit" name="register" class="register">
  </form>
</body>
</html>
