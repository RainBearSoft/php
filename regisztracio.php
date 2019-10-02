<?php
  require_once('mysql.php');
  $mysql = new Mysql();

  $email = $_POST["email"];
  $datum = $_POST["datum"];
  $nem = $_POST["nem"];


  if(isset($email) && isset($datum) && isset($nem)){

    $result = $mysql->connection->query("SELECT azonosito FROM dolgozo WHERE emailCim='".$email."'");
    if(mysqli_num_rows($result) == 0) {
      $result = $mysql->connection->query("SELECT email, ajanloID FROM ajanlasok WHERE email='".$email."'");
      if(mysqli_num_rows($result) > 0) {
        $meghivta = $mysql->fetch($result)[0]["ajanloID"];
        print_r($meghivta);


        $idk = $mysql->fetch($mysql->connection->query("SELECT azonosito FROM dolgozo"));
        $azon = "";
        for ($i=1; $i <= 999; $i++) {
          foreach($idk as $row) {
            if($row["azonosito"] != "D_".$i) { $azon = "D_".$i; break; }
          }

          if($azon != "") break;
        }

        if($azon == "") die("Nincs több elérhető ID");

        echo "INSERT INTO dolgozo VALUES ('".$azon."', '".$datum."', '".$nem."', '".$meghivta."', '0000-00-00', '".$email."', 'A')";
        $insert = $mysql->connection->query("INSERT INTO dolgozo VALUES ('".$azon."', '".$datum."', '".$nem."', '".$meghivta."', NULL, '".$email."', 'A')");
        if($insert) {
          echo "Sikeres regisztráció, azonosító: ".$azon;
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
  <style>
  body{background: url("https://cdn.pixabay.com/photo/2013/07/13/12/52/filmstripe-160520_960_720.png") repeat scroll -5vw 50px;
      background-size: 400px auto;
      transform: rotate("90deg");
      }
  #form1{
    background-color: white;
    border: 3px solid black;
    border-radius: 30px;
    width: 30vw;
    text-align: center;
    margin: 0 auto;}
  </style>
  <script>
  var posX = 50;
    function bg(){
      document.body.style.backgroundPosition= posX/2+Math.sin(posX)*10+"px "+posX+"px";
      posX++;
      setTimeout(bg,50);
    }
  </script>
</head>
<body style="text-align: center" onload="bg()"><div id="form1">
  <h1>Regisztráció</h1>
  <form method="post" action="regisztracio.php">
    <p>E-Mail</p>
    <input type="text" name="email" />
    <p>Születési idő:</p>
    <input type="date" name="datum" />
    <p>Neme:</p>
    <input type="radio" value="F"  name="nem"/> Férfi
    <input type="radio" value="N" name="nem"/> Nő
    <br/>
    <button>Regisztráció</button>

  </form>
</div>
</body>
</html>
