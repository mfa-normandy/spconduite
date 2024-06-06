<?php
// include_once("connectDBclass.inc.php"); pas d'appel automatique car on demande à l'utilisateur de se connecter

// Démarre la session pour l'échange de données via le cookie de session
// le résultat dépend de l'existence du flag mysqliOk 
//(qui est créé dans connectDBclass.inc.php en mode 'login' voir ligne 384 <a href="connectDBclass.inc.php?login=1">)
session_start();
if (isset($_SESSION['mysqliOk'])) {
    $mysqliOk = $_SESSION['mysqliOk'];
    if (strpos($_SESSION['mysqliOk'], 'compte') !== false) {
        include_once ("buildLists.php");
        $mysqliOk = $_SESSION['mysqliOk'];
    }
} else {
    $mysqliOk = "<span style=\"color:red;\">Pressez le bouton Log In pour vous connecter (les cookies doivent être autorisés par votre navigateur).</span><br><br>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=David+Libre:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    
</head>

<body>
    <header>
        <h1>Uniconduite</h1>
    </header>
    <nav>
        <div>
            <div>
                <a href="connectDBclass.inc.php?login=1"><span id="login">Log In</span></a>
            </div>
            <div>
                <a href="appSPC-M2.php"><span id="newsheet"><strong> Créer une fiche de conduite</strong></span></a>
            </div>
            <div>
                <a href="appSPC-M4.php"><span id="stats">Dashboard stastistiques</span></a>
            </div>
        </div>
    </nav>
    <aside>
        <div id="resp-400-image" style="background-image: url('./car.png')"></div>
        <h1>Renseignez les données de votre sortie dans le formulaire ci-dessous</h1>
    </aside>
    <article><br>
        <?php
        echo $mysqliOk;
        ?>
        <form id="formulaire" action="sendForm-M3.php" method="post">
            <fieldset id="time" class="form-grid">
                <label for="date">Date départ</label>
                <input type="date" id="date" name="date" required>
                <label for="heure">Heure départ</label>
                <input type="time" id="heure" name="heure" required>
                <label for="dateR">Date retour</label>
                <input type="date" id="dateR" name="dateR" required>
                <label for="heureR">Heure retour</label>
                <input type="time" id="heureR" name="heureR" required>
            </fieldset>
            <fieldset id="distance" class="form-grid">
                <label for="km">Kilomètres</label>
                <input type="text" id="km" name="km" pattern="\d+" required>
            </fieldset>
            <fieldset id="conditions" class="form-grid">
                <label for="meteo">Meteo</label>
                <select name="meteo" id="meteo" required>
                    <?php
                    foreach ($listeMeteo as $meteo) {
                        if ($meteo['actifMeteo'] == 1)
                            echo '<option value="' . $meteo['idMeteo'] . '">' . $meteo['nomMeteo'] . '</option>';
                    }
                    ;
                    ?>
                    <!-- <option value="1">Clair</option>
                    <option value="2">Nuageux</option>
                    <option value="3">Couvert</option>
                    <option value="4">Pluvieux</option>
                    <option value="5">Brumeux</option>
                    <option value="6">Neigeux</option>
                    <option value="7">Orageux</option>
                    <option value="8">Tempetueux</option> -->
                </select>
                <label for="trafic">Type de trafic</label>
                <select name="trafic" id="trafic" required>
                    <?php
                    foreach ($listeTypeTrafic as $typeTrafic) {
                        if ($typeTrafic['actifTypeTrafic'] == 1)
                            echo '<option value="' . $typeTrafic['idTypeTrafic'] . '">' . $typeTrafic['nomTypeTrafic'] . '</option>';
                    }
                    ;
                    ?>
                    <!--    <option value="1">Faible</option>
                    <option value="2">Modéré</option>
                    <option value="3">Fort</option>
                    <option value="4">Fluctuant</option> -->
                </select>

                <div class="checkbox-container">
                    <br>
                    <label for="route">Type de route</label>
                    <?php
                    if (isset($listeTypeRoute)) {
                        foreach ($listeTypeRoute as $typeRoute) {
                            if ($typeRoute['actifTypeRoute'] == 1) {
                                echo '<div>';
                                echo '<input type="checkbox" id="route' . $typeRoute['idTypeRoute'] . '" name="route[]" value="' . $typeRoute['idTypeRoute'] . '">';
                                echo '<label for="route' . $typeRoute['idTypeRoute'] . '">' . $typeRoute['nomTypeRoute'] . '</label>';
                                echo '</div>';
                            }
                        }
                    }
                    ?>
                </div>  
                <div class="checkbox-container">
                    <br>
                    <label for="manoeuvre">Type de manoeuvre</label>
                    <?php
                    
                    if (isset($listeTypeManoeuvres)) {
                    foreach ($listeTypeManoeuvres as $typeManoeuvre) {
                        //print_r ($typeManoeuvre);
                        if ($typeManoeuvre['actifManoeuvre'] == 1) {
                            echo '<div>';
                            echo '<input type="checkbox" id="manoeuvre' . $typeManoeuvre['idManoeuvre'] . '" name="manoeuvre[]" value="' . $typeManoeuvre['idManoeuvre'] . '">';
                            echo '<label for="manoeuvre' . $typeManoeuvre['idManoeuvre'] . '">' . $typeManoeuvre['nomManoeuvre'] . '</label>';
                            echo '</div>';
                        }
                    }
                }
                    ?>
                </div>             

                
            </fieldset>
            
            <div class="no-grid">
                <br>
                <input type="submit" value="Sauvegarder" id="submit-button">
                <br>
            </div>
        </form>

        <!-- <script>
                
                
            </script> -->

    </article>

    <footer>
        <div id="contactCell"><span>Uniconduite <br><br>
                Copyright 2024 - UNISTRA<br> <a href="mailto:info@uniconduite.com">info@uniconduite.com</a></span>
        </div>
    </footer>
</body>

</html>