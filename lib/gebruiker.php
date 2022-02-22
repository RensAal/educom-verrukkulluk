<?php

class gebruiker {

    private $connection;
    private $table = "gebruikers";

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerGebruiker($gebruiker_ID) {

        $sql = "select * from $this->table where ID = $gebruiker_ID";
        
        $result = mysqli_query($this->connection, $sql);
        $gebruiker = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($gebruiker);

    }


}