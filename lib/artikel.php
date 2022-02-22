<?php

class artikel {

    private $connection;
    private $table = "artikelen";

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerArtikel($artikel_ID) {

        $sql = "select * from $this->table where ID = $artikel_ID";
        echo $sql;
        
        $result = mysqli_query($this->connection, $sql);
        $artikel = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($artikel);

    }


}