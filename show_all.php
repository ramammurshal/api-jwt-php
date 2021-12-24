<?php
  if ($_COOKIE["admin_session"]) {
    $jwt = $_COOKIE["admin_session"];
  }
  else {
    header("Location: index.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show All User</title>
</head>
<body>
  <a href="home_admin.php">< Kembali</a>
  
  <h1>Show All user page (for admin)</h1>
  <div class="lists"></div>
  
  <a href="logout.php">Logout</a>
  
  <p hidden class="jwt"><?php echo $jwt; ?></p>

  <script>
    const jwt = document.querySelector(".jwt").innerText;
    const listsEl = document.querySelector(".lists");

    var requestOptions = {
      method: 'GET',
      redirect: 'follow'
    };

    fetch(`api/users.php?token=${jwt}`, requestOptions)
      .then(response => response.json())
      .then(results => {
        results.data.forEach(item => {
          const data = document.createElement("div");
          data.innerHTML = `
            <ul>
              <li>Nama: ${item.nama}</li>
              <li>Kota: ${item.kota}</li>
              <li>Umur: ${item.umur}</li>
              <li>Username: ${item.username}</li>
              <li>Password after hashing: ${item.password}</li>
              <li>Motivasi: ${item.motivasi}</li>
              <a href="edit_data.php?id=${item.id}">Edit this data</a><br>
              <button class="delete" onclick="deleteData(${item.id})">Delete this data</button>
            </ul><br>
          `;
          listsEl.appendChild(data);
        });
      })
      .catch(error => console.log('error', error));

    function deleteData(id) {
      if (confirm("Press a button!") === true) {
        var requestOptions = {
          method: 'DELETE',
          redirect: 'follow'
        };

        fetch(`api/users.php?id=${id}&token=${jwt}`, requestOptions)
          .then(response => response.text())
          .then(result => console.log(result))
          .catch(error => console.log('error', error));

        alert("Delete user account success");
        window.location.reload(true);
      } 
    }
  </script>
</body>
</html>
