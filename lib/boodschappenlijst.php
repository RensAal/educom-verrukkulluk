<?php

class boodschappenlijst {

    public function maakBoodschappenlijst ($recepten) {
        $artikelen = [];
        echo "<br> <br>";
        var_dump($recepten);
        foreach ($recepten as $recept){
            foreach($recept['ingredienten'] as $newArtikel){
                
                $newArtikel['ID'] = $newArtikel['artikel_ID'];
                unset($newArtikel['artikel_ID']);
                
                $found = false;
                $i=0;
                foreach($artikelen as $artikel){
                    
                    if ($artikelen[$i]['ID'] == $newArtikel['ID']){
                        $artikelen[$i]['hoeveelheid'] += $newArtikel['hoeveelheid'];
                        $found = true;
                        break;
                    }
                        $i++;
                }
                if (!$found){
                    
                    $artikelen[] = $newArtikel;
                }
            }
        }
        $artikelen = $this->herberekenPrijs($artikelen);
        return($artikelen);
    }

    private function herberekenPrijs($artikelen) {
        
        $i=0;
        foreach ($artikelen as $artikel){

            $standaard_prijs = $artikel['prijs'];
            $standaard_hoeveelheid = $artikel['standaard_hoeveelheid'];

            $hoeveelheid = $artikel['hoeveelheid'];

            $prijs = ceil($hoeveelheid / $standaard_hoeveelheid) * $standaard_prijs;

            $artikel['ingredient_prijs'] = $prijs;

            $artikelen[$i] = $artikel;
            $i++;
        
        }
            
        return($artikelen);
    }


}