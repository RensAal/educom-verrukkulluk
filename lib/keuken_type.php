<?php

class keuken_type {

    private $connection;
    private $table = "keuken_type";

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerKeuken_type($ID) {

        $sql = "select * from $this->table where ID = $ID";
        
        $result = mysqli_query($this->connection, $sql);
        $keuken_type = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($keuken_type);

    }


}