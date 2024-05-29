<?php 

    // On va voir si on peut faire quelque chose en CSS de sympa pour les km totaux

    $totalKmRemplissage = $totalKm / 3000 * 100; //ce pourcentage pourra être utilisé en css !
    
    $remplissageHtmlTotalKm = "<div class='remplissage Km'></div>" ; //div qui va afficher la barre d'avancée des Km sur l'objectif des 3000km

    //Afficher les résultats pour les expériences sous différentes météo
    $occurencesMeteoTotal = array_sum($occurencesMeteo); //pour définir ce qui est 100% des expériences
    
    foreach ($occurencesMeteo as $valeur => $compte) {
        $remplissageMeteo[$valeur]=($compte/$occurencesMeteoTotal)*100; //Permet de définir la valeur des occurences de chaque condition (en %) 
    }

    $positionnementMeteoCompteur = 0; //Pour définir où la condition doit se positionner. Peut être que ce serait mieux de la définir au niveau class CSS grâce à la classe valeur{$valeur} ?
    $remplissageHtmlMeteo = ''; //Variable qui va stocker les résultats de la boucle foreach

    foreach ($remplissageMeteo as $valeur => $pourcentage) {
        $positionnementMeteo = $positionnementMeteoCompteur; //permet le décalage à gauche de chaque condition
        $positionnementMeteoCompteur += $pourcentage;
        if($pourcentage > 0){ //on veut afficher seulement les conditions qui ont des trajets
            $remplissageHtmlMeteo .= "<div class='remplissage meteo valeur{$valeur}' style='width: {$pourcentage}%; left: {$positionnementMeteo}%;'><h1>{$occurencesMeteo[$valeur]}</h1></div>";
        }        
    } 

    $occurencesTraficTotal = array_sum($occurencesTrafic); //pour définir ce qui est 100% des expériences
    
    foreach ($occurencesTrafic as $valeur => $compte) {
        $remplissageTrafic[$valeur]=($compte/$occurencesTraficTotal)*100; //Permet de définir la valeur des occurences de chaque condition (en %) 
    }

    $positionnementTraficCompteur = 0; //Pour définir où la condition doit se positionner. Peut être que ce serait mieux de la définir au niveau class CSS grâce à la classe valeur{$valeur} ?
    $remplissageHtmlTrafic = ''; //Variable qui va stocker les résultats de la boucle foreach

    foreach ($remplissageTrafic as $valeur => $pourcentage) {
        $positionnementTrafic = $positionnementTraficCompteur; //permet le décalage à gauche de chaque condition
        $positionnementTraficCompteur += $pourcentage;
        if($pourcentage > 0){ //on veut afficher seulement les conditions qui ont des trajets
            $remplissageHtmlTrafic .= "<div class='remplissage trafic valeur{$valeur}' style='width: {$pourcentage}%; left: {$positionnementTrafic}%;'><h1>{$occurencesTrafic[$valeur]}</h1></div>";
        }        
    } 
?>