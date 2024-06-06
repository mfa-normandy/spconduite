<?php
    
    //connectDB en mode simple (pas en mode login) pour récupérer l'objet mysqli
    include("connectDBclass.inc.php");

    // fonction qui retourne la liste des éléments d'une table
    function retrieveList($mysqliObject, $tableName, $idName, $nomName, $actifName) {
        $retrieveList = $mysqliObject->prepare("SELECT $idName, $nomName, $actifName FROM $tableName");
        $retrieveList->execute();
        $result = $retrieveList->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // récupération des listes
    $listeTypeRoute = retrieveList($mysqliObject, 'TypeRoute', 'idTypeRoute', 'nomTypeRoute', 'actifTypeRoute');
    $listeTypeTrafic = retrieveList($mysqliObject, 'TypeTrafic', 'idTypeTrafic', 'nomTypeTrafic', 'actifTypeTrafic');
    $listeMeteo = retrieveList($mysqliObject, 'Meteo', 'idMeteo', 'nomMeteo', 'actifMeteo');
    $listeTypeManoeuvres = retrieveList($mysqliObject, 'Manoeuvres', 'idManoeuvre', 'nomManoeuvre', 'actifManoeuvre');

?>