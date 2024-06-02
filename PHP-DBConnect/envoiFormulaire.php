<?php

include_once("connectDBclass.inc.php");

echo "<pre>";
print_r($_POST);
echo "</pre>";

//On commence par préparer les données//
$km = $_POST['km']; //On les récupère dans la supervariable $_POST

$dateDepartPost = $_POST['date'] . " " . $_POST['heure']; //Pour les dates, il faut les préparer au bon format !
$dateDepart = new DateTime($dateDepartPost);
$dateDepartFormat = $dateDepart->format('Y-m-d H:i:s');

$dateRetourPost = $_POST['dateR'] . " " . $_POST['heureR'];
$dateRetour = new DateTime($dateRetourPost);
$dateRetourFormat = $dateRetour->format('Y-m-d H:i:s');

$dureeHeure = $dateRetour->diff($dateDepart);
$dureeHeureFormat = $dureeHeure->format('%H:%I:%S'); //Il y a besoin de mettre le résultat sous ce format

$meteo = $_POST['meteo'];

$trafic = $_POST['trafic'];

$typeRoute = $_POST['route']; //On le garde au format tableau pour l'utiliser dans tableau associatif plus bas
$typeRouteGlobal = implode(',', $typeRoute); //On utilise ça pour la requete globale car la colonne est au format str + pas possible de stocker tableau sous le même idTrajet

$manoeuvres = $_POST['manoeuvre'];
$manoeuvresGlobal = implode(',', $manoeuvres); //Pareil que pour typeRoute

//Ensuite on fait une requête qui envoie tout
$sqlGlobal = "INSERT INTO Trajets (Kilometrage, dateDepart, dateRetour, dureeEnHeures, idMeteo, idTrafic, idsTypesRoutes, idsManoeuvres) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)"; //Construction de la requête : dire où l'on insère les différentes values

$declarationGlobale = $mysqliObject->prepare($sqlGlobal);

//Il faut définir le type de données que l'on envoie dans bind_param avec "i=int, s=string"
$declarationGlobale->bind_param("isssiiss", $km, $dateDepartFormat, $dateRetourFormat, $dureeHeureFormat, $meteo, $trafic, $typeRouteGlobal, $manoeuvresGlobal); 

$declarationGlobale->execute();

//On va essayer d'alimenter les tableaux de correspondances//

$maxIdTrajet = $mysqliObject->insert_id;

$declarationGlobale->close();

foreach($manoeuvres as $manoeuvre){ //On fait des requêtes spécifiques pour alimenter les tableaux de correspondances
    $sqlManoeuvre = "INSERT INTO TrajetsManoeuvres (idTrajet, idManoeuvre)
                    VALUES (?, ?)" ;
    $declarationManoeuvre = $mysqliObject->prepare($sqlManoeuvre);

    $declarationManoeuvre->bind_param("ii", $maxIdTrajet, $manoeuvre);

    $declarationManoeuvre->execute();

    $declarationManoeuvre->close();

};

foreach($typeRoute as $route){ //On fait des requêtes spécifiques pour alimenter les tableaux de correspondances
    $sqlRoute = "INSERT INTO TrajetsRoutes (idTrajet, idTypeRoute)
                    VALUES (?, ?)" ;
    $declarationRoute = $mysqliObject->prepare($sqlRoute);

    $declarationRoute->bind_param("ii", $maxIdTrajet, $route);

    $declarationRoute->execute();

    $declarationRoute->close();

};

header('Location:appSPC-4.php'); // Permet d'aller sur une page en particulier une fois tout ce code exécuté

exit();

?>