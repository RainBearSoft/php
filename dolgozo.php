<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="utf-8">
    <title>Dolgozó belépés</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <style>
      * { margin: 5px ; padding: 0;}
      body {
        font-family: Arial;
        text-align: center;
      }

      button {
        margin: 5px;
        padding: 3px 10px;
      }

      #cont {
        position: absolute;
        width: 30%;
        height: 30%;
        z-index: 15;
        top: 50%;
        left: 50%;
        margin: -15% 0 0 -15%;
      }

      input {
        width:50%;
      }
    </style>
  </head>
  <body>
    <div id="cont">
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

                $update = $mysql->connection->query('UPDATE dolgozo WHERE azonosito="'.$row["azonosito"].'" AND emailCim="'.$row["emailCim"].'" SET belepesDatuma=CURRENT_TIMESTAMP');

                $_SESSION["azon"] = $row["azonosito"];
                $_SESSION["email"] = $row["emailCim"];
                $_SESSION["belepve"] = true;

                header("Location: dolgozo_menu.html");
              }
            }else echo "Nincs ilyen: ".mysqli_num_rows($result);
          }else echo "üres";

        }else echo "Üres";
      ?>
      <form method="post" action="dolgozo.php">
        <p>E-Mail Cím:</p>
        <input type="text" name="email"/>
        <br>
        <p>Azonosító:</p>
        <input type="password" name="azon"/>
        <br/>
        <button>Bejelentkezés</button>
      </form>
      <p>vagy</p>
      <a href="regisztracio.php">Regisztráció</a>
    </div>
  </body>
</html>
