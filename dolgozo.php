<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="utf-8">
    <title>Dolgozó belépés</title>
  </head>
  <body>
      <h1>Bejelentkezés</h1>
      <?php
        require 'mysql.php';
        $mysql = new Mysql();

        session_start();
        $email = $_POST["email"];
        $azon = $_POST["azon"];
        if(isset($email) && isset($azon)) {
          if($azon != "" && $email != "") {
            $q = 'SELECT azonosito, emailCim FROM dolgozo WHERE azonosito="'.$azon.'" AND emailCim="'.$email.'"';
            $result = $mysql->connection->query($q);
            echo "result: ".mysqli_num_rows($result);
            if(mysqli_num_rows($result) > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "SIKERESEN BELÉPTÉL: ".$row['emailCim']."(".$row['azonosito'].")";
                $_SESSION["azon"] = $row["azonosito"];
                $_SESSION["email"] = $row["emailCim"];
                $_SESSION["belepve"] = true;

              }
            }else echo "Nincs ilyen: ".mysqli_num_rows($result);
          }else echo "üres";

        }else echo "Üres";
      ?>
      <form method="post" action="dolgozo.php">
        <p>E-Mail</p>
        <input type="text" name="email"/>
        <p>Azonosító</p>
        <input type="password" name="azon"/>
        <button>Elküld</button>
      </form>
      <a href="regisztracio.php">Regisztráció</a>
  </body>
</html>
