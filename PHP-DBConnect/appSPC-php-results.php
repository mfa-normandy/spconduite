<?php
    include_once("connectDBclass.inc.php");
    include_once("ajoutListesChoix.php");
    include_once("recupererResultat.php")
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
    <script>
        window.onload = function() {
            //Selectionner plusieurs manoeuvres
            var select = document.getElementById('manoeuvre'); 
                select.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    var select = this;
                    var index = Array.from(select.options).indexOf(e.target);
                    if (e.target.tagName.toLowerCase() !== 'option' || index === -1) return;
                    select.options[index].selected = !select.options[index].selected;
                    return false;
                    }
                );

            //Selectionner plusieurs types de routes
            var select = document.getElementById('route'); 
            select.addEventListener('mousedown', function(e) {
                e.preventDefault();
                var select = this;
                var index = Array.from(select.options).indexOf(e.target);
                if (e.target.tagName.toLowerCase() !== 'option' || index === -1) return;
                select.options[index].selected = !select.options[index].selected;
                return false;
                }
            );
        }
    </script>


    <style>
        * {    
            box-sizing: border-box;
        }
        body {
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 1fr 1fr 1fr 1fr;
            height: 100vh; /* Subtract double the gridgap from the height */
            width: 400px; /* Subtract double the gridgap from the width */
            /* margin:10px;*/
            margin-left:auto;
            margin-right:auto;
            /*grid-gap:15px;*/
            
        }
        header {
            grid-column: 1;
            grid-row: 1;
            width: 400px;
            padding: 5px;
            background-color: rgb(33,78,168);
            color: white;
            font-family: David Libre, sans-serif;
            font-size: 0.8em;
            text-align: center;
            height: auto;
        }
        /*
        nav {
            grid-column: 1;
            grid-row: 2;
            width: 400px;
            background-color: rgb(33,78,168);
            padding-right: 5px;
            padding-bottom: 5px;
            text-align: right;
        }
        nav table { 
            width: 400px;
            height: 100%;
        }
        */
        
        nav {
            grid-column: 1;
            grid-row: 2;
            width: 400px;
            background-color: rgb(33,78,168);
            padding-right: 5px;
            padding-bottom: 5px;
            text-align: right;
            display: flex; /* Add this line to make the nav a flex container */
            flex-direction: column; /* Add this line if you want the items to stack vertically */
        }
        
        nav div { /* Replaced 'table' with 'div' */
            width: auto;
            height: 95%;
            display: flex;
            justify-content: right;
        }

        nav div span {
            text-align: center;
            background-color: rgb(33,78,168);
            color: white;
            font-family: Arial, sans-serif;
            font-size: 0.7em;
            padding: 5px;
            border: 1px solid white;
            border-radius: 5px;
            width: auto;
            height:auto;

        }

        aside {
            grid-column: 1;
            grid-row: 3;
            position: relative;
            width: 400px; /* adjust as needed */
            
        }
        aside h1 {
            position: absolute;
            top: -15px;
            /* transform: translate(-50%, -50%);*/
            color: rgb(33,78,168); /* adjust as needed */
            background-color: white;
            opacity: 0.8;
            width: 400px;
            text-align: center;
            font-family: David Libre, sans-serif;
            font-size: 20px;
        }
        aside img {
            width: 400px;
            height: 120px;  /*REGLE LE PROBLEME D'IMAGE*/
        }
        
        #stats {
            background-color: rgb(255, 255, 255);
            color: rgb(33, 78, 168);
        }
        
        
        article {
            grid-column: 1 ;
            grid-row: 4;
            padding: 5px;
            width: 400px;
        }
        
        footer {
            /* grid-column: 1; */ 
            grid-row: 7 ;
            color: white;
            font-family: Arial, sans-serif;
            font-size: 1em;
            padding: 15px;
            width: 400px;
            height: auto;
            background-color: rgb(33,78,168);
        }
        
        div.root{ /*rajout de la marge pour les pieds de graphique*/
            margin-bottom: 140px;
            width:400px;
        }

        div.root::before{ /*rajout de before pour séparer les graphiques*/
            content:"";
            height:1px;
            border: solid 1px #214EA8;
            background-color:#214EA8;
            width:30%;
            margin:auto;
            display: block;
            margin-bottom: 40px;
        }

        div.no-root{ /*Annuler margin-bottom trop grande */
            margin-bottom: 10px;
        }

        div.root h2{
            text-align: center;
            font-size: 1.1em;
            line-height: 1.3em;
            color:black;
        }

        div.rv-discrete-color-legend-item svg path{ /*Agrandir la couleur des légendes */
            stroke-width:10px;
        }

        div.rv-discrete-color-legend-item span{ /*Agrandir le texte*/
            font-size: 1.2em;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: 1fr;
            gap: 1px;
        }
        
        label {
            grid-column: 1;
            height: 30px;
        }
        
        input  {
            grid-column: 2;
            height: 30px;
        }
        
        input:valid, select:valid {
            border: 2px solid green;
        }
        
        input:invalid, select:invalid {
            border: 2px solid rgb(255, 162, 0);
        }
        
        input[type="submit"] {
            background-color: rgb(33,78,168);
            color: white;
            border: 1px solid rgb(33,78,168);
            border-radius: 5px;
            padding: 10px 20px; /* adjust as needed */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px; /* adjust as needed */
            margin: 4px 2px;
            cursor: pointer;
        }
        fieldset {
            border: 1px solid rgb(167, 193, 245);
            border-radius: 5px;
            padding: 10px;
            margin: 1px;
        }
        a {
            color: white;
            text-decoration: none;
        }

        /*A modifier pour que ça s'adapte bien avec le bandeau */
        #TotalKm{
            text-align: center;
            font-weight: bold;
        }
        /*Ma proposition d'ajout : transformer le texte fin d'ul en un titre h2 pour + de visibilité*/
        h2{
            color: rgb(33,78,168);
            font-size: 1.2em;
        }

        /*Gérer le tableau récapitulatif de ce qui a été réalisé comme trajets */
        section{
            grid-row: 5;
        }
        
        section table{
            width: 100%;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        table th, table td, table tr{
            width: auto;
            text-align: center;
        }

        table{
            border-collapse: collapse;
        }

        table td{
            border:solid 1px black;  
        }
        table tr th{
            border:solid 1px black;            
        }
        
        .ligne-recapitulatif{
            border:solid 1px black;  
            text-align: center;
            background-color: rgb(33,78,168);
            color:white;
        }

        #root-kmAgg .rv-xy-plot__grid-lines__line {
            stroke: blue !important;
        }

    </style>
</head>
<!-- NE PAS MODIFIER LE CODE CI-APRES -->
<body>
    <header>
        <h1>Uniconduite</h1>
    </header>
    <nav>
        <div>
            <div>
                <span id="login">Log In</span>
            </div>
            <div>
                <a href="appSPC-php.php"><span id="newsheet"><strong> Créer une fiche de conduite</strong></span></a>
            </div>
            <div>
                <a href="appSPC-php-results.php"><span id="stats">Dashboard stastistiques</span></a>
            </div>
        </div>
    </nav>
    <aside>
        <img id="resp-400-image" src="./car.png" alt="Logo" width="400" height="120">
        
        <h1>Résumé de vos experiences de conduite</h1>
    </aside>
    <article>
        <footer>
            <div id="contactCell"><span>Uniconduite <br><br>
                Copyright 2024 - UNISTRA<br> <a href="mailto:info@ecoleoscar.com">info@uniconduite.com</a></span>
            </div>
        </footer>
    </article>
</body>
</html>
