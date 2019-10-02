<?php
  require_once('mysql.php');
  $mysql = new Mysql();

  $email = $_POST["email"];
  $azon = $_POST["azon"];
  $datum = $_POST["datum"];
  $nem = $_POST["nem"];


  if(isset($email) && isset($azon) && isset($datum) && isset($nem)){
    $result = $mysql->connection->query("SELECT azonosito FROM dolgozo WHERE emailCim='".$email."'");
    if(mysqli_num_rows($result) == 0) {
      $result = $mysql->connection->query("SELECT email, ajanloID FROM ajanlasok WHERE email='".$email."'");
      if(mysqli_num_rows($result) > 0) {
        $meghivta = $mysql->fetch($result)[0]["ajanloID"];
        print_r($meghivta);

        echo "INSERT INTO dolgozo VALUES ('".$azon."', '".$datum."', '".$nem."', '".$meghivta."', '0000-00-00', '".$email."', 'A')";
        $insert = $mysql->connection->query("INSERT INTO dolgozo VALUES ('".$azon."', '".$datum."', '".$nem."', '".$meghivta."', NULL, '".$email."', 'A')");
        if($insert) {
          echo "Sikeres regisztráció";
        }else echo "Sikertelen regisztráció";
      }
    }else echo "Van már ilyen felhasználó!";
  }


?>

<!DOCTYPE html>
<html>
<head>
  <title>Dolgozói regisztráció</title>
  <meta charset="utf-8" />
</head>
<body>
  <h1>Regisztráció</h1>
  <form method="post" action="regisztracio.php">
    <p>E-Mail</p>
    <input type="text" name="email" />
    <p>Azonosító</p>
    <input type="text"name="azon" />
    <p>Születési idő:</p>
    <input type="date" name="datum" />
    <p>Neme:</p>
    <input type="radio" value="F"  name="nem"/> Férfi
    <input type="radio" value="N" name="nem"/> Nő
    <br/>
    <button>Regisztráció</button>

  </form>
</body>
</html>
