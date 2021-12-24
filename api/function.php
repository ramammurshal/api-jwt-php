<?php
  include("connection.php");
  require __DIR__ . '/vendor/autoload.php';
  $secret_key = "ramzbilz";

  // LOGIN
  function get_row($role, $username) {
    global $connect;

    if ($role === "user") {
      return mysqli_query($connect, "SELECT * from user WHERE user_username = '$username'"); 
    }
    else {
      return mysqli_query($connect, "SELECT * from admin WHERE admin_username = '$username'"); 
    }
  }

  function check_password($role, $password, $row) {
    if ($role === "user") {
      return password_verify($password, $row["user_password"]);
    }
    else if ($role === "admin") {
      return password_verify($password, $row["admin_password"]);
    }
  }

  function create_jwt($role, $row) {
    global $secret_key;

    // for user
    if ($role === "user") {
      $payload = [
        "id" => $row["user_id"],
        "username" => $row["user_username"],
        "role" => "user",
      ];
      $jwt = \Firebase\JWT\JWT::encode($payload, $secret_key,'HS256');
      setcookie("user_session", $jwt, time() + 3600);
      setcookie("id", $row["user_id"], time() + 3600);
    }

    // for admin
    else if ($role === "admin") {
      $payload = [
        "id" => $row["admin_id"],
        "username" => $row["admin_username"],
        "role" => "admin",
      ];
      $jwt = \Firebase\JWT\JWT::encode($payload, $secret_key,'HS256');
      setcookie("admin_session", $jwt, time() + 3600);
    }
  }

  function login($data, $role) {
    global $connect;

    $username = $data["username"];
    $password = $data["password"];

    $result = get_row($role, $username);
    if (mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);

      if (check_password($role, $password, $row)) {
        create_jwt($role, $row);
        return true;
      }
    }
    return false;
  }
?>
