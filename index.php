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

/// VERWERK

/*
URL:
http://localhost/index.php?recept_ID=4&action=detail
*/
$recept_ID = isset($_GET["recept_ID"]) ? $_GET["recept_ID"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";

switch($action) {

    case "homepage": {
        $data = $recept->selecteerRecept();
        $template = 'homepage.html.twig';
        $title = "homepage";
        break;
    }

    case "detail": {
        $data = $recept->selecteerRecept($recept_id);
        $template = 'detail.html.twig';
        $title = "detail pagina";
        break;
    }

    /// etc

}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);


/// INIT
//$db = new database();
//$recept = new recept($db->getConnection());
//$lijst = new boodschappenlijst();

//$recept_ID = [1, 1, 3, 4];
//$gebruiker_ID = 1;
/// VERWERK 
//$data = $recept->selecteerRecept($recept_ID, $gebruiker_ID);

//$data = $lijst->maakBoodschappenlijst($data);

/// RETURN
//echo "<br> <br>";
//var_dump($data);