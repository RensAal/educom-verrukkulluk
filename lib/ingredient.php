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

        $i = 0;
        while($ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            
            $artikel_ID = $ingredient['artikel_ID'];
            $art = new artikel($this->connection);
            $artikel = $art->selecteerArtikel($artikel_ID);
            
            $ingredienten[$i] = $ingredient;
            $ingredienten[$i] = $this->berekenPrijs($ingredienten[$i], $artikel);
            $ingredienten[$i] = $this->berekenCalorien($ingredienten[$i], $artikel);
            
            $i++;
        }

        return($ingredienten);
    }

    private function berekenPrijs($ingredient, $artikel) {
        $artikel_prijs = $artikel['prijs'];
        $standaard_hoeveelheid = $artikel['standaard_hoeveelheid'];

        $hoeveelheid = $ingredient['hoeveelheid'];

        $prijs = ceil($hoeveelheid / $standaard_hoeveelheid) * $artikel_prijs;

        $ingredient = $ingredient + ['prijs'=> $prijs];
            
        return($ingredient);
    }


    private function berekenCalorien($ingredient, $artikel) {
        $artikel_calorien = $artikel['caloriën'];
        $standaard_hoeveelheid = $artikel['standaard_hoeveelheid'];

        $hoeveelheid = $ingredient['hoeveelheid'];

        $calorien = ($hoeveelheid / $standaard_hoeveelheid) * $artikel_calorien;

        $ingredient = $ingredient + ['calorien'=> $calorien];
            
        return($ingredient);

    }


}