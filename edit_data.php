<?php
  if (isset($_COOKIE["user_session"])) {
    $jwt = $_COOKIE["user_session"];
    $id = $_COOKIE["id"];
  }
  else if (isset($_COOKIE["admin_session"])) {
    $jwt = $_COOKIE["admin_session"];
    $id = $_GET["id"];
  }
  else {
    header("Location: index.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit data</title>
  <style>
    label, textarea {
      display: block;
    }

    input, textarea {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <?php if(isset($_COOKIE["user_session"])) { ?>
    <a href="home.php">< Kembali</a>
  <?php } else { ?>
    <a href="show_all.php">< Kembali</a>
  <?php } ?>
  <br><br>

  <h1>Edit data</h1>
  
  <form action="" method="POST">
    <label for="nama">Nama:</label>
    <input type="text" name="nama" id="nama" class="nama" required><br>

    <label for="umur">Umur:</label>
    <input type="number" name="umur" id="umur" class="umur" required><br>

    <label for="kota">Kota:</label>
    <input type="text" name="kota" id="kota" class="kota" required><br>

    <label for="username">Username:</label>
    <input type="text" name="username" id="username" class="username" required><br>

    <label for="password1">Password: (setelah hash)</label>
    <input type="password" name="password1" id="password1" class="password1" required><br>

    <span class="notsame" hidden style="color: red;">Konfirmasi password tidak sama</span>
    <label for="password2">Konfirmasi password:</label>
    <input type="password" name="password2" id="password2" class="password2" required><br>

    <label for="motivasi">Motivasi hidup:</label>
    <textarea name="motivasi" id="motivasi" cols="30" rows="10" class="motivasi" required></textarea>
    
    <input type="submit" value="Update" name="update" class="update">
  </form>

  <p class="jwt" hidden><?php echo $jwt ?></p>
  <p class="id" hidden><?php echo $id ?></p>

  <script>
    const jwt = document.querySelector(".jwt").innerText;
    const id = document.querySelector(".id").innerText;
    
    const updateBtn = document.querySelector(".update");
    const namaInput = document.querySelector(".nama");
    const umurInput = document.querySelector(".umur");
    const kotaInput = document.querySelector(".kota");
    const usernameInput = document.querySelector(".username");
    const password1Input = document.querySelector(".password1");
    const password2Input = document.querySelector(".password2");
    const motivasiInput = document.querySelector(".motivasi");

    // get data
    var requestOptions = {
      method: 'GET',
      redirect: 'follow'
    };

    fetch(`api/users.php?token=${jwt}&id=${id}`, requestOptions)
      .then(response => response.json())
      .then(result => {
        namaInput.value = result.data.nama;
        kotaInput.value = result.data.kota;
        umurInput.value = result.data.umur;
        usernameInput.value = result.data.username;
        password1Input.value = result.data.password;
        motivasiInput.value = result.data.motivasi;
      })
      .catch(error => console.log('error', error));
    // end of get data
    
    updateBtn.addEventListener("click", (event) => {
      event.preventDefault();
    
      if (password1Input.value === password2Input.value) {

        // update data
        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

        var urlencoded = new URLSearchParams();
        urlencoded.append("nama", namaInput.value);
        urlencoded.append("umur", umurInput.value);
        urlencoded.append("kota", kotaInput.value);
        urlencoded.append("username", usernameInput.value);
        urlencoded.append("password", password1Input.value);
        urlencoded.append("motivasi", motivasiInput.value);

        var requestOptions = {
          method: 'PUT',
          headers: myHeaders,
          body: urlencoded,
          redirect: 'follow'
        };

        fetch(`api/users.php?token=${jwt}&id=${id}`, requestOptions)
          .then(response => response.text())
          .then(result => console.log(result))
          .catch(error => console.log('error', error));
        // end of update data

        alert("Update user account success");
        window.location.reload(true);
      }
      else {
        document.querySelector(".notsame").removeAttribute("hidden");
      }
    });
  </script>
</body>
</html>
