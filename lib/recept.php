<?php

class recept{

    private $connection;
    private $table = "recepten";

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerRecept($recept_ID, $gebruiker_ID) {

        $sql = "select * from $this->table where ID = $recept_ID";
        
        $result = mysqli_query($this->connection, $sql);
        $recept = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        $recept = $this->selecteerIngredienten($recept);
        $recept = $this->berekenPrijs($recept);
        $recept = $this->berekenCalorien($recept);

        $recept = $this->selecteerWaardering($recept);
        $recept = $this->selecteerBereiding($recept);
        $recept = $this->selecteerOpmerkingen($recept);
        $recept = $this->selecteerFavoriet($recept, $gebruiker_ID);

        return($recept);
    }

    private function selecteerIngredienten($recept) {

        $ingredienten = new ingredient($this->connection);
        $ingredienten_array = $ingredienten->selecteerIngredienten($recept['ID']);

        $recept += ['ingredienten' => $ingredienten_array];

        return($recept);        
    }

    private function selecteerBereiding($recept) {

        $recept_info = new recept_info($this->connection);
        $recept_info_array = $recept_info->selecteerRecept_info($recept['ID']);

        $bereiding = NULL;
        foreach ($recept_info_array as $record){
            if ($record['record_type'] == "B"){
                $bereiding[$record['numeriekveld']] = $record;
            }
        }

        $recept += ['bereiding' => $bereiding];

        return ($recept);        
    }

    private function selecteerOpmerkingen($recept) {

        $recept_info = new recept_info($this->connection);
        $recept_info_array = $recept_info->selecteerRecept_info($recept['ID']);
        
        $opmerkingen = NULL;
        foreach ($recept_info_array as $record){
            if ($record['record_type'] == "O"){
                $opmerkingen[] = $record;
            }
        }  
        
        $recept += ['opmerkingen' => $opmerkingen];

        return ($recept);
    }

    private function selecteerWaardering($recept) {

        $recept_info = new recept_info($this->connection);
        $recept_info_array = $recept_info->selecteerRecept_info($recept['ID']);
        
        $waardering = NULL;
        $waarderingen = 0;
        $i = 0;
        foreach ($recept_info_array as $record){
            if ($record['record_type'] == "W"){
                $waarderingen += $record['numeriekveld'];
                $i++;
            }
            if ($i > 0) {
                $waardering = $waarderingen / $i;
            }
        }        

        $recept += ['waardering' => $waardering];

        return ($recept);      
    }

    private function selecteerFavoriet($recept, $gebruiker_ID) {

        $recept_info = new recept_info($this->connection);
        $recept_info_array = $recept_info->selecteerRecept_info($recept['ID']);
        
        $favoriet = FALSE;

        foreach ($recept_info_array as $record){
            if (($record['record_type'] == "F") AND ($record['gebruiker_ID'] == $gebruiker_ID) ){
                $favoriet = TRUE;
                break;
            }
        }        

        $recept += ['favoriet' => $favoriet];

        return ($recept);  
    }

    private function berekenPrijs($recept) {
        
        $i=0;
        foreach ($recept['ingredienten'] as $ingredient){

            $artikel_prijs = $ingredient['artikel']['prijs'];
            $standaard_hoeveelheid = $ingredient['artikel']['standaard_hoeveelheid'];

            $hoeveelheid = $ingredient['hoeveelheid'];

            $prijs = ceil($hoeveelheid / $standaard_hoeveelheid) * $artikel_prijs;

            $ingredient += ['prijs'=> $prijs];

            $recept['ingredienten'][$i] = $ingredient;
            $i++;
        
        }
            
        return($recept);
    }


    private function berekenCalorien($recept) {
        
        $i = 0;
        foreach ($recept['ingredienten'] as $ingredient){

            $artikel_calorien = $ingredient['artikel']['caloriën'];
            $standaard_hoeveelheid = $ingredient['artikel']['standaard_hoeveelheid'];

            $hoeveelheid = $ingredient['hoeveelheid'];

            $calorien = ($hoeveelheid / $standaard_hoeveelheid) * $artikel_calorien;

            $ingredient += ['calorien'=> $calorien];

            $recept['ingredienten'][$i] = $ingredient;

            $i++;

        }
            
        return($recept);

    }


}