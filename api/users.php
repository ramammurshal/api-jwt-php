<?php
  $request_method = $_SERVER["REQUEST_METHOD"];
  include("utilitys.php");

  if (empty($_GET["token"])) {
    echo "Token not inserted";
    die();
  }

  switch($request_method) {
    case 'GET':
      if(!empty($_GET["id"])) {
        getUser($_GET["id"], $_GET["token"]);
      }
      else {
        getAll($_GET["token"]);
      }
      break;
    case 'POST':
      createUser($_GET["token"]);
      break;
    case 'PUT':
      if (!empty($_GET["id"])) {
        updateData($_GET["token"], $_GET["id"]);
      }
      else {
        echo "Id not inserted";
      }
      break;
    case 'DELETE':
      if (!empty($_GET["id"])) {
        deleteUser($_GET["token"], $_GET["id"]);
      }
      else {
        echo "Id not inserted";
      }
      break;
  }
?>
