<?php
  if (!$_COOKIE["admin_session"]) {
    header("Location: index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
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
  <a href="home_admin.php">< Kembali</a><br><br>
  <h1>Create account for user from admin</h1>

  <form action="" method="POST">
    <label for="nama">Nama:</label>
    <input type="text" name="nama" id="nama" class="nama" required><br>

    <label for="umur">Umur:</label>
    <input type="number" name="umur" id="umur" class="umur" required><br>

    <label for="kota">Kota:</label>
    <input type="text" name="kota" id="kota" class="kota" required><br>

    <label for="username">Username:</label>
    <input type="text" name="username" id="username" class="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" class="password1" required><br>
    
    <span class="notsame" hidden style="color: red;">Konfirmasi password tidak sama</span>
    <label for="password2">Konfirmasi password:</label>
    <input type="password" name="password2" id="password2" class="password2" required><br>

    <label for="motivasi">Motivasi:</label>
    <textarea name="motivasi" id="motivasi" cols="30" rows="10" class="motivasi" required></textarea>
    
    <input type="submit" value="Buat" name="register" class="register">
  </form>

  <p class="jwt" hidden><?php echo $_COOKIE["admin_session"] ?></p>

  <script>
    const jwt = document.querySelector(".jwt").innerText;

    const registerBtn = document.querySelector(".register");
    const namaInput = document.querySelector(".nama");
    const umurInput = document.querySelector(".umur");
    const kotaInput = document.querySelector(".kota");
    const usernameInput = document.querySelector(".username");
    const password1Input = document.querySelector(".password1");
    const password2Input = document.querySelector(".password2");
    const motivasiInput = document.querySelector(".motivasi");

    registerBtn.addEventListener("click", (event) => {
      event.preventDefault();
      
      if (namaInput.value !== "" && umurInput.value !== "" && kotaInput.value !== "" && usernameInput.value !== "" && password1Input.value !== "" && password2Input.value !== "" && motivasiInput.value !== "") {

        if (password1Input.value === password2Input.value) {
          var formdata = new FormData();
          formdata.append("nama", namaInput.value);
          formdata.append("umur", umurInput.value);
          formdata.append("kota", kotaInput.value);
          formdata.append("username", usernameInput.value);
          formdata.append("password", password1Input.value);
          formdata.append("motivasi", motivasiInput.value);

          var requestOptions = {
            method: 'POST',
            body: formdata,
            redirect: 'follow'
          };

          fetch(`api/users.php?token=${jwt}`, requestOptions)
            .then(response => response.text())
            .then(result => console.log(result))
            .catch(error => console.log('error', error));
          
          alert("Create user account success");
          window.location.reload(true);
        }
        else {
          document.querySelector(".notsame").removeAttribute("hidden");
        }
      }
    });
  </script>
</body>
</html>
