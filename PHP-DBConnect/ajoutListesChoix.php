<?php
    include("connectDBclass.inc.php");

    // D'abord les TYPES DE ROUTE

    $retrieveListeTypeRoute = $mysqliObject->prepare('SELECT idTypeRoute, nomTypeRoute, actifTypeRoute FROM TypeRoute'); //on indique ce que la variable prend dans la BDD

    $retrieveListeTypeRoute->execute(); //on exécute la requête SQL

    $resultTypeRoute = $retrieveListeTypeRoute->get_result(); //on récupère les résultats mais sous forme d'obet mysqli_result

    $listeTypeRoute = $resultTypeRoute->fetch_all(MYSQLI_ASSOC); //transforme l'objet mysqli_result en tableau associatif

    //Après dans le fichier index, on va utiliser une boucle foreach pour faire apparaître les éléments, s'ils sont bien notés comme actifs (1)

    //Ensuite les TYPES DE TRAFIC

    $retrieveListeTypeTrafic = $mysqliObject->prepare('SELECT idTypeTrafic, nomTypeTrafic, actifTypeTrafic FROM TypeTrafic');

    $retrieveListeTypeTrafic->execute();

    $resultTypeTrafic = $retrieveListeTypeTrafic->get_result();

    $listeTypeTrafic = $resultTypeTrafic->fetch_all(MYSQLI_ASSOC);

    //Ensuite les TYPES DE METEO

    $retrieveListeMeteo = $mysqliObject->prepare('SELECT idMeteo, nomMeteo, actifMeteo FROM Meteo');

    $retrieveListeMeteo->execute();

    $resultMeteo = $retrieveListeMeteo->get_result();

    $listeMeteo = $resultMeteo->fetch_all(MYSQLI_ASSOC);

    //Ensuite les TYPES DE MANOEUVRES

    $retrieveListeTypeManoeuvres = $mysqliObject->prepare('SELECT idManoeuvre, nomManoeuvre, actifManoeuvre FROM Manoeuvres');

    $retrieveListeTypeManoeuvres->execute();

    $resultTypeManoeuvres = $retrieveListeTypeManoeuvres->get_result();

    $listeTypeManoeuvres = $resultTypeManoeuvres->fetch_all(MYSQLI_ASSOC);

?>