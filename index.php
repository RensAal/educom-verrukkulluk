<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/gebruiker.php");
require_once("lib/ingredient.php");
require_once("lib/keuken_type.php");
require_once("lib/recept_info.php");
require_once("lib/recept.php");
require_once("lib/boodschappenlijst.php");

//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("./vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("./templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());


/// INIT
$db = new database();
$recept = new recept($db->getConnection());
$recept_info = new recept_info($db->getConnection());
$lijst = new boodschappenlijst($db->getConnection());
$artikel = new artikel($db->getConnection());

$gebruiker_ID = 1;
/// VERWERK

/*
URL:
http://localhost/index.php?recept_ID=4&action=detail
*/

$recept_ID = isset($_GET["recept_ID"]) ? $_GET["recept_ID"] : "1";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";
$artikel_ID = isset($_GET["artikel_ID"]) ? $_GET["artikel_ID"] : "";

switch($action) {

    case "homepage": {
        $data = $recept->selecteerRecept();
        $template = 'homepage.html.twig';
        $title = "homepage";
        break;
    }

    case "zoeken": {
        $data = [];
        $recepten = $recept->selecteerRecept();
        $zoeken = $_POST['zoeken'];
        foreach ($recepten as $record) {
            $string = json_encode($record);
            if ( !$zoeken or str_contains(strtolower($string),strtolower($zoeken))){
                $data[] = $record;
            } 
        }
        $template = 'homepage.html.twig';
        $title = "homepage";
        break;
    }

    case "detail": {
        $data = $recept->selecteerRecept($recept_ID, $gebruiker_ID);
        $template = 'detail.html.twig';
        $title = "detail pagina";
        break;
    }

    case "lijst": {
        $data = $lijst->selecteerBoodschappenlijst($gebruiker_ID);
        $template = 'lijst.html.twig';
        $title = "lijst pagina";
        break;
    }

    case "opLijst": {
        $lijst->boodschappenToevoegen($recept_ID, $gebruiker_ID);
        header("Location: http://localhost/educom-verrukkulluk/educom-verrukkulluk/index.php?action=lijst");
        break;
    }

    case "deleteLijst": {
        $lijst->deleteLijst($gebruiker_ID);
        $data = $lijst->selecteerBoodschappenlijst($gebruiker_ID);
        $template = 'lijst.html.twig';
        $title = "lijst pagina";
        break;
    }

    case "deleteBoodschap": {
        $lijst->deleteBoodschap($artikel_ID, $gebruiker_ID);
        $data = $lijst->selecteerBoodschappenlijst($gebruiker_ID);
        $template = 'lijst.html.twig';
        $title = "lijst pagina";
        break;
    }

    case "updateBoodschap": {

        $hoeveelheid = $_POST['hoeveelheid'];
       
        $lijst->updateBoodschap($artikel_ID, $gebruiker_ID, $hoeveelheid);
        $artikel_data = $artikel->selecteerArtikel($artikel_ID); 
        $data = ["success" => true, "hoeveelheid" => $hoeveelheid, "standaard_hoeveelheid" => $artikel_data['standaard_hoeveelheid'], "prijs" => $artikel_data['prijs']];
        
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        die();
    }

    case "waardering": {
        $rating = $_POST['rating'];
        $recept_info->addWaardering($recept_ID, $rating);
        
        $data = ["success" => true, "rating" => $rating];
        
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        die();
    }

    case "favoriet": {
        $favorite = $_POST['favorite'];

        if ($favorite == "true"){$recept_info->addFavoriet($recept_ID, $gebruiker_ID);}
        if ($favorite == "false"){$recept_info->deleteFavoriet($recept_ID, $gebruiker_ID);}
        
        $data = ["success" => true, "favorite" => $favorite];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        die();
    }

    /// etc

}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);

/*
/// INIT
$db = new database();
$recept = new recept($db->getConnection());
$lijst = new boodschappenlijst();

$recept_ID = 1;
$gebruiker_ID = 1;
/// VERWERK 
$data = $recept->selecteerRecept($recept_ID, $gebruiker_ID);

$data = $lijst->maakBoodschappenlijst($data);

/// RETURN
echo "<br> <br>";
var_dump($data);
*/