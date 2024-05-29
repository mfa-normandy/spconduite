<?php
    include("connectDBclass.inc.php");

    //On prend d'abord les résultats, on les obtient de cette manière sous forme de tableau//

    $resultats = $mysqliObject->prepare('SELECT idTrajet, Kilometrage, dateDepart, dateRetour, dureeEnHeures, idMeteo, idTrafic, idsTypesRoutes, idsManoeuvres, actifTrajet FROM Trajets');

    $resultats->execute();

    $resultats = $resultats->get_result();

    $resultats = $resultats->fetch_all(MYSQLI_ASSOC);
    
    //Ensuite, il nous faut les libellés des différentes conditions avec ID //
    //On commence par la météo//

    $nomMeteo = $mysqliObject->prepare('SELECT idMeteo, nomMeteo, actifMeteo FROM Meteo');

    $nomMeteo->execute();

    $nomMeteo = $nomMeteo->get_result();

    $nomMeteo = $nomMeteo->fetch_all(MYSQLI_ASSOC);

    //Les manoeuvres//

    $nomManoeuvres = $mysqliObject->prepare('SELECT idManoeuvre, nomManoeuvre, actifManoeuvre FROM Manoeuvres');

    $nomManoeuvres->execute();

    $nomManoeuvres = $nomManoeuvres->get_result();

    $nomManoeuvres = $nomManoeuvres->fetch_all(MYSQLI_ASSOC);

    //Les types de route//

    $nomTypeRoute = $mysqliObject->prepare('SELECT idTypeRoute, nomTypeRoute, actifTypeRoute FROM TypeRoute');

    $nomTypeRoute->execute();

    $nomTypeRoute = $nomTypeRoute->get_result();

    $nomTypeRoute = $nomTypeRoute->fetch_all(MYSQLI_ASSOC);

    //Les types de trafic//

    $nomTypeTrafic = $mysqliObject->prepare('SELECT idTypeTrafic, nomTypeTrafic, actifTypeTrafic FROM TypeTrafic');

    $nomTypeTrafic->execute();

    $nomTypeTrafic = $nomTypeTrafic->get_result();

    $nomTypeTrafic = $nomTypeTrafic->fetch_all(MYSQLI_ASSOC);

    //Mapper les résultats avec les noms pour l'affichage ensuite //

    $mapMeteo = array_column($nomMeteo, 'nomMeteo', 'idMeteo');
    $mapManoeuvres = array_column($nomManoeuvres, 'nomManoeuvre', 'idManoeuvre');
    $mapTypeRoute = array_column($nomTypeRoute, 'nomTypeTrafic', 'idTypeTrafic');
    $mapTypeTrafic = array_column($nomTypeTrafic, 'idTypeTrafic', 'nomTypeTrafic');


    class Resultat{
        public $idTrajet;
        public $kilometrage;
        public $date;
        public $duree;
        public $meteo;
        public $trafic; 
        public $typeRoute;
        public $manoeuvres;
        public $actifTrajet;

        public function __construct($idTrajet, $kilometrage, $date, $duree, $meteo, $trafic, $typeRoute, $manoeuvres, $actifTrajet){
            $this->idTrajet = $idTrajet;
            $this->kilometrage = $kilometrage;
            $this->date = $date;
            $this->duree = $duree;
            $this->meteo = $meteo;
            $this->trafic = $trafic;
            $this->typeRoute = $typeRoute;
            $this->manoeuvres = $manoeuvres;
            $this->actifTrajet = $actifTrajet;
        }
    }

    $trajets=[];

    foreach($resultats as $resultat){
        $trajets[] = new Resultat(
            $resultat['idTrajet'],
            $resultat['Kilometrage'],
            $resultat['dateDepart'],
            $resultat['dureeEnHeures'],
            $resultat['idMeteo'],
            $resultat['idTrafic'],
            $resultat['idsTypesRoutes'],
            $resultat['idsManoeuvres'],
            $resultat['actifTrajet']
        );
    }

    

?>
