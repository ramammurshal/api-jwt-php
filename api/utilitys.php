<?php
  $secret_key = "ramzbilz";
  require __DIR__ . '/vendor/autoload.php';
  include("connection.php");

  function generateToken($jwt) {
    global $secret_key;
    try {
      $payload = \Firebase\JWT\JWT::decode($jwt, $secret_key, ['HS256']);
      return $payload;
    }
    catch (Exception $error) {
      echo "False token";
      die();
    }
  }

  function getUser($id, $token) {
    global $connect;
    $payload = generateToken($token);

    if (($payload->role === "user" && $payload->id === $id) || $payload->role === "admin") {
      $query = mysqli_query($connect, "SELECT * from user WHERE user_id = $id");
      if ($query) {
        $results = mysqli_fetch_all($query, MYSQLI_ASSOC);
        foreach ($results as $result) {
          $item = array(
            "id" => $result["user_id"],
            "nama" => $result["user_nama"],
            "umur" => $result["user_umur"],
            "kota" => $result["user_kota"],
            "username" => $result["user_username"],
            "password" => $result["user_password"],
            "motivasi" => $result["user_motivasi"]
          );
        }

        $response = [
          "status" => "Ok",
          "msg" => "Succes get data",
          "data" => $item,
        ];
          
        echo json_encode($response);
      }
      else {
        echo "Something wrong";
      }
    }
    else {
      echo "You cannot access other people data";
    }
  }

  function getAll($token) {
    global $connect;
    $payload = generateToken($token);

    if ($payload->role === "admin") {
      $query = mysqli_query($connect, "SELECT * from user");
      $results = mysqli_fetch_all($query, MYSQLI_ASSOC);
  
      foreach ($results as $result) {
        $item[] = array(
          "id" => $result["user_id"],
          "nama" => $result["user_nama"],
          "umur" => $result["user_umur"],
          "kota" => $result["user_kota"],
          "username" => $result["user_username"],
          "password" => $result["user_password"],
          "motivasi" => $result["user_motivasi"]
        );
      }
      
      $response = array(
        "status" => "Ok",
        "msg" => "Success get data",
        "data" => $item
      );
      echo json_encode($response);
    }
    else {
      echo "You cannot access this";
    }
  }

  function createUser($token) {
    global $connect;
    $payload = generateToken($token);

    if ($payload->role === "admin") {
      $nama = isset($_POST["nama"]) ? $_POST["nama"] : "";
      $kota = isset($_POST["kota"]) ? $_POST["kota"] : "";
      $umur = isset($_POST["umur"]) ? $_POST["umur"] : "";
      $username = isset($_POST["username"]) ? $_POST["username"] : "";
      $password = isset($_POST["password"]) ? $_POST["password"] : "";
      $motivasi = isset($_POST["motivasi"]) ? $_POST["motivasi"] : "";

      $password = password_hash($password, PASSWORD_DEFAULT);

      $query = mysqli_query($connect, "INSERT INTO user VALUES('', '$nama', '$umur', '$kota', '$username', '$password', '$motivasi')");

      if ($query) {
        $response = array(
          "status" => "Ok",
          "msg" => "Success insert data"
        );
      }
      else {
        $response = array(
          "status" => "Bad",
          "msg" => "Failed insert data"
        );
      }

      echo json_encode($response);
    }
    else {
      echo "You cannot access this";
    }
  }

  function updateData($token, $id) {
    global $connect;
    $payload = generateToken($token);

    if (($payload->role === "user" && $payload->id === $id) || $payload->role === "admin") {
      parse_str(file_get_contents('php://input'), $_PUT);

      $nama = isset($_PUT["nama"]) ? $_PUT["nama"] : "";
      $kota = isset($_PUT["kota"]) ? $_PUT["kota"] : "";
      $umur = isset($_PUT["umur"]) ? $_PUT["umur"] : "";
      $username = isset($_PUT["username"]) ? $_PUT["username"] : "";
      $password = isset($_PUT["password"]) ? $_PUT["password"] : "";
      $motivasi = isset($_PUT["motivasi"]) ? $_PUT["motivasi"] : "";
  
      $password = password_hash($password, PASSWORD_DEFAULT);
  
      $query = mysqli_query($connect, "UPDATE user SET user_nama = '$nama', user_kota = '$kota', user_umur = '$umur', user_username = '$username', user_password = '$password', user_motivasi = '$motivasi' WHERE user_id = $id");
  
      if ($query) {
        $response = array(
          "status" => "Ok",
          "msg" => "Success update data"
        );
      }
      else {
        $response = array(
          "status" => "Bad",
          "msg" => "Failed update data"
        );
      }
  
      echo json_encode($response);
    }
    else {
      echo "You cannot access this";
    }
  }

  function deleteUser($token, $id) {
    global $connect;
    $payload = generateToken($token);

    if ($payload->role === "admin") {
      $query = mysqli_query($connect, "DELETE FROM `user` WHERE `user`.`user_id` = $id");
      if ($query) {
        $response = array(
          "status" => "Ok",
          "msg" => "Success delete data"
        );
      }
      else {
        $response = array(
          "status" => "Bad",
          "msg" => "Failed delete data"
        );
      }
      echo json_encode($response);
    }
    else {
      echo "You cannot access this";
    }
  }
?>
