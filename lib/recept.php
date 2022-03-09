<?php

class recept{

    private $connection;
    private $table = "recepten";

    public function __construct($connection) {
        $this->connection = $connection;
    }
  
    public function selecteerRecept($recept_ID = NULL, $gebruiker_ID = NULL) {
        
            
            $sql = "select * from $this->table"; 
            if($recept_ID != NULL) {$sql .= " where ID = $recept_ID";}
            
            $result = mysqli_query($this->connection, $sql);
            
            while($recept = mysqli_fetch_array($result, MYSQLI_ASSOC)){

                $recept = $this->selecteerIngredienten($recept);
                $recept = $this->berekenPrijs($recept);
                $recept = $this->berekenCalorien($recept);
    
                $recept = $this->selecteerWaardering($recept);
                $recept = $this->selecteerBereiding($recept);
                $recept = $this->selecteerOpmerkingen($recept);
                
                if($gebruiker_ID != NULL) {$recept = $this->selecteerFavoriet($recept, $gebruiker_ID);}
                
                $recept = $this->selecteerKeuken($recept);
                $recept = $this->selecteerType($recept);

                $recepten[] = $recept;

            }
        
        return($recepten);
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

    private function selecteerKeuken($recept) {

        $keuken = new keuken_type($this->connection);
        $keuken_array = $keuken->selecteerKeuken_type($recept['keuken_ID']);
        
        $recept += ['keuken' => $keuken_array['omschrijving']];

        return ($recept);  
    }

    private function selecteerType($recept) {

        $type = new keuken_type($this->connection);
        $type_array = $type->selecteerKeuken_type($recept['type_ID']);
        
        $recept += ['type' => $type_array['omschrijving']];

        return ($recept); 
    }

    private function berekenPrijs($recept) {
        
        $i=0;
        $totaal_prijs = 0;
        foreach ($recept['ingredienten'] as $ingredient){

            $artikel_prijs = $ingredient['prijs'];
            $standaard_hoeveelheid = $ingredient['standaard_hoeveelheid'];

            $hoeveelheid = $ingredient['hoeveelheid'];

            $prijs = ceil($hoeveelheid / $standaard_hoeveelheid) * $artikel_prijs;
            $totaal_prijs += $prijs;

            $ingredient += ['ingredient_prijs'=> $prijs];

            $recept['ingredienten'][$i] = $ingredient;
            $i++;
        
        }
        $recept['totaal_prijs'] = $totaal_prijs;
            
        return($recept);
    }


    private function berekenCalorien($recept) {
        
        $i = 0;
        $totaal_calorien = 0;
        foreach ($recept['ingredienten'] as $ingredient){

            $artikel_calorien = $ingredient['caloriën'];
            $standaard_hoeveelheid = $ingredient['standaard_hoeveelheid'];

            $hoeveelheid = $ingredient['hoeveelheid'];

            $calorien = round(($hoeveelheid / $standaard_hoeveelheid) * $artikel_calorien);
            $totaal_calorien += $calorien;

            $ingredient += ['ingredient_calorien'=> $calorien];

            $recept['ingredienten'][$i] = $ingredient;

            $i++;

        }
        $recept['totaal_calorien'] = $totaal_calorien;

        return($recept);

    }


}