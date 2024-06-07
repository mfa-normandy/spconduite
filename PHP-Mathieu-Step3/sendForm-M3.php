<?php

include_once("connectDBclassPDO.inc.php"); // Connnexion via le dsn et création de l'objet PDO

echo "<pre>";
print_r($_POST);
echo "</pre>";

// Preparation des données pour l'insertion dans la base de données
$km = $_POST['km'];

$dateDepartPost = $_POST['date'] . " " . $_POST['heure'];
$dateDepart = new DateTime($dateDepartPost);
$dateDepartFormat = $dateDepart->format('Y-m-d H:i:s');

$dateRetourPost = $_POST['dateR'] . " " . $_POST['heureR'];
$dateRetour = new DateTime($dateRetourPost);
$dateRetourFormat = $dateRetour->format('Y-m-d H:i:s');

$dureeHeure = $dateRetour->diff($dateDepart);
$dureeHeureFormat = $dureeHeure->format('%H:%I:%S');

$meteo = $_POST['meteo'];
$trafic = $_POST['trafic'];

$typeRoute = $_POST['route'];
$typeRouteGlobal = implode(',', $typeRoute);
$manoeuvres = $_POST['manoeuvre'];
$manoeuvresGlobal = implode(',', $manoeuvres);

// Sécurisation de la requête avec paramètres
$sqlGlobal = "INSERT INTO Trajets (Kilometrage, dateDepart, dateRetour, dureeEnHeures, idMeteo, idTypeTrafic, idsTypesRoutes, idsManoeuvres) 
                VALUES (:km, :dateDepart, :dateRetour, :duree, :meteo, :trafic, :typeRoute, :manoeuvres)";
$statementGlobal = $pdoObject->prepare($sqlGlobal);

// Bind the parameters
$statementGlobal->bindParam(':km', $km, PDO::PARAM_INT);
$statementGlobal->bindParam(':dateDepart', $dateDepartFormat, PDO::PARAM_STR);
$statementGlobal->bindParam(':dateRetour', $dateRetourFormat, PDO::PARAM_STR);
$statementGlobal->bindParam(':duree', $dureeHeureFormat, PDO::PARAM_STR);
$statementGlobal->bindParam(':meteo', $meteo, PDO::PARAM_INT);
$statementGlobal->bindParam(':trafic', $trafic, PDO::PARAM_INT);
$statementGlobal->bindParam(':typeRoute', $typeRouteGlobal, PDO::PARAM_STR);
$statementGlobal->bindParam(':manoeuvres', $manoeuvresGlobal, PDO::PARAM_STR);

// Execute the statement
$statementGlobal->execute();

// Get the last inserted ID
$maxIdTrajet = $pdoObject->lastInsertId();

foreach($manoeuvres as $manoeuvre){
    $sqlManoeuvre = "INSERT INTO TrajetsManoeuvres (idTrajet, idManoeuvre)
                    VALUES (:idTrajet, :manoeuvre)";
    $statementManoeuvre = $pdoObject->prepare($sqlManoeuvre);
    $statementManoeuvre->bindParam(':idTrajet', $maxIdTrajet, PDO::PARAM_INT);
    $statementManoeuvre->bindParam(':manoeuvre', $manoeuvre, PDO::PARAM_INT);
    $statementManoeuvre->execute();
};

foreach($typeRoute as $route){
    $sqlRoute = "INSERT INTO TrajetsRoutes (idTrajet, idTypeRoute)
                    VALUES (:idTrajet, :route)";
    $statementRoute = $pdoObject->prepare($sqlRoute);
    $statementRoute->bindParam(':idTrajet', $maxIdTrajet, PDO::PARAM_INT);
    $statementRoute->bindParam(':route', $route, PDO::PARAM_INT);
    $statementRoute->execute();
};

header('Location:appSPC-M2.php'); // Permet d'aller sur une page en particulier une fois tout ce code exécuté

exit();

?>