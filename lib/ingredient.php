<?php

class ingredient {

    private $connection;
    private $table = "ingrediënten";

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerIngredienten($recept_ID) {

        $sql = "select * from $this->table where recept_ID = $recept_ID";
        
        $result = mysqli_query($this->connection, $sql);

        while($ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            
            $artikel_ID = $ingredient['artikel_ID'];
            $artikel = new artikel($this->connection);
            $artikel_array = $artikel->selecteerArtikel($artikel_ID);
            unset($artikel_array['ID']);
            $ingredienten[] = array_merge($ingredient, $artikel_array);
        }

        return($ingredienten);
    }




}