<?php
  $servername = "localhost";
  $usernameDB = "root";
  $passwordDB = "";
  $DBname = "jwtpeweb";

  $connect = mysqli_connect($servername, $usernameDB, $passwordDB, $DBname);
  if(!$connect) {
    exit("Gagal koneksi database!");
  }

  // $servername = "sql111.epizy.com";
  // $usernameDB = "epiz_30635248";
  // $passwordDB = "Lj0ald2uSb";
  // $DBname = "epiz_30635248_jwtpeweb";

  // $connect = mysqli_connect($servername, $usernameDB, $passwordDB, $DBname);
  // if(!$connect) {
  //   exit("Gagal koneksi database!");
  // }
?>
