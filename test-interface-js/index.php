<?php
    include_once("head.php");
?>

<body>
<header>
    <div class="navigation">
        <h1><span>UniConduite</span></h1>
        <nav aria-label="Menu principal">
            <ul>
                <li><a href="#">Se connecter</a></li>
                <li><a href="index.php">Enregistrer une expérience</a></li>
                <li><a href="dashboard.php">Vérifier l'avancée</a></li>
            </ul>
        </nav>
    </div>
</header>
    <main>
        <section class="ajouter-experience" id="ajouterExperience">
            <h2>Enregistrer une nouvelle expérience de conduite ?</h2>
            <p>L'application UniConduite permet de suivre votre avancée dans la conduite accompagnée. Grace à elle, vous pouvez voir le nombre de kilomètres effectués, mais aussi le temps passé à vous entraîner à conduire, les types d'exercices réalisés et dans quelles conditions !</p> 
            <p>Tout cela vous permet de vraiment savoir quand vous serez prêt à passer l'examen du permis.</p>
            <button id="lancerForm" aria-label="Cliquez pour commencer à enregistrer une expérience de conduite">
                <img src="img/signe-plus-blanc.png">
            </button>
        </section>
        <section id="sectionForm" class="hidden">
            <h2>Enregistrer votre expérience de conduite</h2>
            <form id="formulaire">
                <fieldset id="time" class="deux-colonnes">
                    <h3>Quand êtes vous parti et revenu ?</h3>
                    <div class="gauche">
                        <label for="date">Date départ</label>
                        <input type="date" id="date" name="date" required>
                        <label for="heure" class="heure">Heure départ</label>
                        <input type="time" id="heure" name="heure" required> 
                    </div>
                    <div class="droite">
                        <label for="dateR">Date retour</label>
                        <input type="date" id="dateR" name="dateR" required>  
                        <label for="heureR" class="heure">Heure retour</label>
                        <input type="time" id="heureR" name="heureR" required> 
                    </div>
                </fieldset>
                <fieldset id="distance" class="">
                    <h3>Combien de kilomètres avez-vous roulé ?</h3>
                    <div class="centre">
                        <label for="km">Kilomètres</label>
                        <input type="text" id="km" name="km" pattern="\d+" placeholder="Renseignez les km parcourus" required>
                    </div> 
                </fieldset>
                <fieldset id="conditions" class="deux-colonnes">
                    <h3> Vous avez roulé...</h3>
                    <div class="gauche">
                        <label for="meteo">Sous quel météo ?</label>
                        <select name="meteo" id="meteo" required>
                            <option value="" hidden>-- Indiquer la météo --</option> 
                            <!-- <option value="1">Clair</option>
                            <option value="2">Nuageux</option>
                            <option value="3">Couvert</option>
                            <option value="4">Pluvieux</option>
                            <option value="5">Brumeux</option>
                            <option value="6">Neigeux</option>
                            <option value="7">Orageux</option>
                            <option value="8">Tempetueux</option> -->
                        </select>
                    </div>
                    
                    <div class="droite">
                        <label for="trafic">Avec quel trafic ? </label>
                        <select name="trafic" id="trafic" required>
                            <option value="" hidden>-- Indiquer le trafic --</option>
                            <!--    <option value="1">Faible</option>
                            <option value="2">Modéré</option>
                            <option value="3">Fort</option>
                            <option value="4">Fluctuant</option> -->
                        </select>
                    </div>
                    <div class="gauche">
                        <label for="route">Sur quel type de route ?</label>
                        <select name="route[]" id="route" required multiple>
                            <option value="" hidden>-- Indiquer les types de routes  --</option> 
                            <!--   <option value="1">Nationale</option>
                            <option value="2">Départementale</option>
                            <option value="3">Autoroute</option>
                            <option value="4">3Centre-ville</option>
                            <option value="5">Mixte</option>  -->
                        </select>
                    </div>
                    <div class="droite">
                        <label for="manoeuvre">En faisant quelles manoeuvres ?</label>
                        <select name="manoeuvre[]" id="manoeuvre" required multiple>
                            <option value="" hidden>-- Indiquer les manoeuvres réalisées --</option>
                            <!--  
                            <option value="1">  Stationnement en épi</option>
                            <option value="1"> Stationnement en bataille</option>
                            <option value="1">  Stationnement en créneau</option> -->
                        </select>  
                    </div>
                </fieldset>
                <button type="submit" id="envoyerForm" aria-label="Cliquez pour enregistrer l'expérience !">
                    <img src="img/signe-plus-blanc.png" alt="Submit" >
                </button>
            </form>
        </section>
        <section class="hidden" id="afficherRecap">
            <h2>Voici les trajets déjà réalisés</h2>

        </section>
    </main>
</body>
<footer>
    <div>
        <span>UniConduite</span>
        <div>
            <p>Projet réalisé par l'équipe 4</p>
            <p>Abdousmane, Kossy, Mathieu, Samy & Théo</p>
        </div>
        <nav aria-label="Menu principal">
            <ul>
                <li><a href="#">Se connecter</a></li>
                <li><a href="#">Enregistrer une expérience</a></li>
                <li><a href="#">Vérifier l'avancée</a></li>
            </ul>
        </nav>
    </div>    
</footer> 

</html>