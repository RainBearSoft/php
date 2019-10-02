<?php
  class Mysql {
    public $connection;

    function __construct() {
      $this->connection = new mysqli("localhost", "tanulo5", "qwertz", "tanulo5_dusza2016");
      if(!$this->connection) {
        echo "Nem lehetett csatlakozni az adatbázishoz." . PHP_EOL;
        echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Error: " . mysqli_connect_error() . PHP_EOL;
        exit;
      }

      echo "MySQL kapcsolódás sikerült!";
    }

    function fetch($q) {
      $tomb = array();
      while($tomb[] = $q->fetch_assoc());
      return $tomb;
    }

  }
?>
