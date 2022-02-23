<?php

class recept_info {

    private $connection;
    private $table = "recept_info";

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerRecept_info($recept_ID) {
        
        $sql = "select * from $this->table where recept_ID = $recept_ID";
        $result = mysqli_query($this->connection, $sql);
        
        while($recept_info = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                     
            $recept_info = $this->selecteerGebruiker($recept_info);

            $recept_info_array[] = $recept_info;

        }

        return($recept_info_array);

    }

    private function selecteerGebruiker($recept_info) {

        $gebruiker_ID = NULL;
        if ($recept_info['record_type'] == "O" /*OR $recept_info['record_type'] == "F"*/){
            
            $gebruiker_ID = $recept_info['gebruiker_ID'];
            
            $gebruiker = new gebruiker($this->connection);
            $gebruiker_array = $gebruiker->selecteerGebruiker($gebruiker_ID);
            
            $recept_info = array_merge($recept_info, $gebruiker_array);

        }

        return ($recept_info);
    }

    public function addFavoriet($recept_ID, $gebruiker_ID) {
        
        $sql = "insert into $this->table (record_type, recept_ID, gebruiker_ID) values('F', $recept_ID, $gebruiker_ID)";

        $result = mysqli_query($this->connection, $sql);

    }

    public function deleteFavoriet($recept_ID, $gebruiker_ID) {

        $sql = "delete from $this->table where recept_ID = $recept_ID AND gebruiker_ID = $gebruiker_ID";
        
        $result = mysqli_query($this->connection, $sql);

    }

}