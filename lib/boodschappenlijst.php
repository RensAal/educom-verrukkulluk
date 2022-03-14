<?php

class boodschappenlijst {
    private $connection;
    private $table = "boodschappen";

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function boodschappenToevoegen ($recept_ID, $gebruiker_ID) {
        $recept_class = new recept($this->connection);
        $recept = $recept_class->selecteerRecept($recept_ID)[0];

            foreach($recept['ingredienten'] as $artikel){
                
                $boodschap = $this->artikelOpLijst($artikel['artikel_ID'], $gebruiker_ID); 
                
                if($boodschap){
                    $boodschap['hoeveelheid'] += $artikel['hoeveelheid'];
                    $this->updateBoodschap($boodschap['artikel_ID'], $boodschap['gebruiker_ID'], $boodschap['hoeveelheid']);
                }

                if(!$boodschap){
                    $this->addBoodschap($artikel['artikel_ID'], $gebruiker_ID, $artikel['hoeveelheid']);
                }
            }
        
        return;
    }
    
    private function artikelOpLijst ($artikel_ID, $gebruiker_ID) {
       
                $boodschappen = $this->selecteerBoodschappenlijst($gebruiker_ID);
                
                foreach($boodschappen as $boodschap){
                        
                    if ($boodschap['artikel_ID'] == $artikel_ID){
                        return($boodschap);
                    }
                }

                return(false);
    }



    public function selecteerBoodschappenlijst ($gebruiker_ID) {
        
        $sql = "select * from $this->table where gebruiker_ID = $gebruiker_ID";
        $result = mysqli_query($this->connection, $sql);
        
        $boodschappenlijst = [];

        while($boodschap = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                     
            $boodschap = $this->selecteerArtikel($boodschap);
            
            $boodschappenlijst[] = $boodschap;

        }
        
        return($boodschappenlijst);
    }

    private function selecteerArtikel($boodschap) {
          
            $artikel = new artikel($this->connection);
            $artikel_array = $artikel->selecteerArtikel($boodschap['artikel_ID']);
            
            $boodschap = array_merge($boodschap, $artikel_array);
            $boodschap = $this->berekenAantal($boodschap);

        return ($boodschap);
    }

    private function berekenAantal($boodschap) {
        
            $standaard_hoeveelheid = $boodschap['standaard_hoeveelheid'];

            $hoeveelheid = $boodschap['hoeveelheid'];
            $aantal = ceil($hoeveelheid / $standaard_hoeveelheid);
            
            $boodschap['aantal'] = $aantal;
        
        return($boodschap);
    }

    public function addBoodschap($artikel_ID, $gebruiker_ID, $hoeveelheid) {
        
        $sql = "insert into $this->table (artikel_ID, gebruiker_ID, hoeveelheid) values($artikel_ID, $gebruiker_ID, $hoeveelheid)";
    
        $result = mysqli_query($this->connection, $sql);
    }

    public function updateBoodschap($artikel_ID, $gebruiker_ID, $hoeveelheid) {
        
        $sql = "update $this->table set hoeveelheid = $hoeveelheid where artikel_ID = $artikel_ID AND gebruiker_ID = $gebruiker_ID";
    
        $result = mysqli_query($this->connection, $sql);
    }
    
    public function deleteBoodschap($artikel_ID, $gebruiker_ID) {
    
        $sql = "delete from $this->table where artikel_ID = $artikel_ID AND gebruiker_ID = $gebruiker_ID";
            
        $result = mysqli_query($this->connection, $sql);
    }

    public function deleteLijst($gebruiker_ID) {
    
        $sql = "delete from $this->table where gebruiker_ID = $gebruiker_ID";
            
        $result = mysqli_query($this->connection, $sql);
    }

}