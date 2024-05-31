<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=David+Libre:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="styles/reset.css" rel="stylesheet">
    <link href="styles/style.scss" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <script src="script/onDemandCharts.js"></script>
    <script src="script/cacherDiv.js"></script>
    <script src="https://unpkg.com/react@16/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone@7.24.4/babel.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/react-vis/dist/style.css">
    <script type="text/javascript" src="https://unpkg.com/react-vis/dist/dist.min.js"></script>
    <script type="text/babel" src="script/afficherCharts.js"></script>
        
</head>
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
        <section class="root resultats">
            <div class="deux-colonnes">
                <h2 >Voici le récapitulatif des résultats de vos trajets !</h2>
            </div>
            <div class="cacher" id="cacher">
                <p>Il n'y a pas encore de trajets enregistrés, il faut commencer par ça.</p>
                <a href="index.php">
                    <button aria-label="Cliquez pour aller sur la page d'enregistrement d'expérience !">
                        <img src="img/signe-plus-blanc.png" alt="Submit" >
                    </button>
                </a>
            </div>  
            <div id="root-km" class="root no-root">

            </div>
            <div id="root-kmAgg" class="root no-root">

            </div>
            <div id="root-stationnement" class="root">

            </div>
            <div id="root-route" class="root">

            </div>
            <div id="root-meteo" class="root">

            </div>
            <div id="root-trafic" class="root no-root">

            </div>
            
        </section>
        <section class="resultats ai">
            <div class="deux-colonnes">
                <h2>Demandez a notre de bot de visualisation de construire vos diagrammes personnalisés! </h2>
            </div>
            <div class="gauche">
                <p>Exemple : je veux voir la proportion de chaque condition meteo sur l'ensemble des trajets sous forme de camembert.<br></p>
                <p>Pour cela, veuillez remplir et envoyer le formulaire avec votre souhait de visualisation.</p>
            </div>
                
                <!--EMPLACEMENT DU CODE OPENAI-->
                <div class="droite">
                    <form id="formulaire">
                    <fieldset id="promptfs" class="form-grid">
                        <label for="oaipass">Votre passkey OpenAI API</label>
                        <input value="" type="text" id="oaipass" name="oaipass" required>
                        <label for="prompt">Mes statistiques personnalisées avec Chat GPT 3.5</label>
                        <textarea id="prompt" name="prompt" required rows="10">please highlight the percentage of trips per idConditionMeteo in a piechart</textarea>
                    </fieldset>
                    <div class="no-grid">
                        <input type="submit" value="Envoyer">
                    </div>
                    </form>
                    <div id="response"></div>
                </div>
        </section>
          
        <!--FIN         DU CODE OPENAI-->
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
    </body>
    </html>
