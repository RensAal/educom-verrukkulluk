<?php

class recept_info {

    private $connection;
    private $table = "recept_info";

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerRecept_info($recept_info_ID) {

        $sql = "select * from $this->table where ID = $recept_info_ID";
        
        $result = mysqli_query($this->connection, $sql);
        $recept_info = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($recept_info);

    }

    public function getGebruiker($recept_info_ID) {

        $recept_info = $this->selecteerRecept_info($recept_info_ID); 

        $gebruiker_ID = NULL;
        if ($recept_info['record_type'] == "O" OR $recept_info['record_type'] == "F"){
            $gebruiker_ID = $recept_info['gebruiker_ID'];
        }

    }

    public function addFavoriet($recept_ID, $gebruiker_ID) {
        
        $sql = "insert into $this->table (record_type, recept_ID, gebruiker_ID) values('F', $recept_ID, $gebruiker_ID)";

        $result = mysqli_query($this->connection, $sql);

    }

    public function deleteFavoriet($recept_info_ID) {

        $sql = "delete from $this->table where ID = $recept_info_ID";
        
        $result = mysqli_query($this->connection, $sql);

    }

}