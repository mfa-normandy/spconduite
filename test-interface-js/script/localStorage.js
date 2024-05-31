window.onload = function() {
    // format storage 
    // let listeTrajets = [{"idTrajet":1,"duree":{"heureDepart":"2024-03-05T15:00:00.000Z","heureFin":"2024-03-05T16:00:00.000Z"},"kilometres":123,"conditions":{"idConditionMeteo":3,"idTypeRoute":2,"idTypeTraffic":1},"manoeuvres":[0,1]},{"idTrajet":2,"duree":{"heureDepart":"2024-03-06T15:00:00.000Z","heureFin":"2024-03-06T16:00:00.000Z"},"kilometres":107,"conditions":{"idConditionMeteo":1,"idTypeRoute":1,"idTypeTraffic":1},"manoeuvres":[2]}];//variables//
    let meteo = [{"meteoId":1,"temps":"Clair"},{"meteoId":2,"temps":"Nuageux"},{"meteoId":3,"temps":"Couvert"},{"meteoId":4,"temps":"Pluvieux"},{"meteoId":5,"temps":"Brumeux"},{"meteoId":6,"temps":"Neigeux"},{"meteoId":7,"temps":"Orageux"},{"meteoId":8,"temps":"Tempetueux"}];
    let typeRoute = [{"typeRouteId":1,"typeRouteNom":"Nationale"},{"typeRouteId":2,"typeRouteNom":"Départementale"},{"typeRouteId":3,"typeRouteNom":"Autoroute"},{"typeRouteId":4,"typeRouteNom":"Centre-ville"},{"typeRouteId":5,"typeRouteNom":"Mixte"}];
    let typeTraffic = [{"traficId":1,"typeTrafic":"Faible"},{"traficId":2,"typeTrafic":"Modéré"},{"traficId":3,"typeTrafic":"Fort"},{"traficId":4,"typeTrafic":"Fluctuant"}];
    let manoeuvres = [{"manoeuvreId":1,"manoeuvreNom":"Stationnement en épi"},{"manoeuvreId":2,"manoeuvreNom":"Stationnement en bataille"},{"manoeuvreId":3,"manoeuvreNom":"Stationnement en créneau"}];    
    //construction des listes
    let selectMeteo = document.getElementById("meteo");
    let selectRoute = document.getElementById("route");
    let selectTrafic = document.getElementById("trafic");
    let selectManoeuvre = document.getElementById("manoeuvre");
    //meteo
    for (let i = 0; i < meteo.length; i++) {
        let option = document.createElement("option");
        option.value = meteo[i].meteoId;
        option.text = meteo[i].temps;
        selectMeteo.appendChild(option);
    }
    //route
    for (let i = 0; i < typeRoute.length; i++) {
        let option = document.createElement("option");
        option.value = typeRoute[i].typeRouteId;
        option.text = typeRoute[i].typeRouteNom;
        selectRoute.appendChild(option);
    }
    //trafic
    for (let i = 0; i < typeTraffic.length; i++) {
        let option = document.createElement("option");
        option.value = typeTraffic[i].traficId;
        option.text = typeTraffic[i].typeTrafic;
        selectTrafic.appendChild(option);
    }
    //manoeuvres
    for (let i = 0; i < manoeuvres.length; i++) {
        let option = document.createElement("option");
        option.value = manoeuvres[i].manoeuvreId;
        option.text = manoeuvres[i].manoeuvreNom;
        selectManoeuvre.appendChild(option);
    }


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

//On prépare de quoi accéder à ce qui est déjà stocké dans le localstorage
let listeTrajets = localStorage.getItem('trajets') //Avec ça, on récupère le localstorage, au cas où il y ait déjà des trajets enregistrés
if(listeTrajets === null){ //On regarde s'il y a des trajets d'enregistré
   listeTrajets=[] //Devient un tableau vide si 0 trajets enregistrés
} else {
    listeTrajets = JSON.parse(listeTrajets) //Sinon, on retransforme la variable en tableau contenant les trajets du localStorage
}

let totalKm = 0 //Stocke les km parcourus


var enregistrementLocalStorage = localStorage.getItem('trajets')
const trajetParse = JSON.parse(enregistrementLocalStorage)//On retransforme tout en une variable qui contient un objet, si on veut la voir dans le console.log

console.log(trajetParse)

//Afficher où on en est dans l'apprentissage
const objectifKm = 3000; //Définition de l'objectif à atteindre

if(localStorage.getItem('trajets') !== null){ //On vérifie si il y a déjà des infos dans la key trajets
    trajetParse.forEach(trajet =>
        totalKm += Number(trajet.kilometres) //transforme chaque propriétés kilomètres de chaque trajet en un nombre et l'ajoute au total parcouru
    )
}

let objectifKmRestant = objectifKm - totalKm

//Afficher du texte pour les km parcourus

if(totalKm > 0){
        let affichageAvancee = document.querySelector('.ajouter-experience')
        let nouveauTotalKm = document.createElement("p")
        nouveauTotalKm.textContent = "Félicitations, vous avez déjà conduit " + totalKm + "km ! Plus que " + objectifKmRestant + " à parcourir !"
        nouveauTotalKm.id = "TotalKm"
        nouveauTotalKm.classList.add("envoyee")
        affichageAvancee.prepend(nouveauTotalKm)
    }

    let compteur = listeTrajets.length+1
//Pour insérer des éléments dans le localStorage, il faut prendre le formulaire
var formulaire = document.getElementById("formulaire"); //On récupère le formulaire

//Fonction pour ajouter des éléments dans le localStorage
formulaire.addEventListener('submit', ()=>{
    
     //Utilisé pour faire l'ID trajet
    
    //Récupérer la value de la date de départ//
    let nouveauDepart = document.getElementById("date").value

    //Récupérer la  value de l'heure de départ//
    let nouveauHeureDepart = document.getElementById("heure").value

    //Récupérer la value de la date du retour//
    let nouveauRetour = document.getElementById("dateR").value

    //Récupérer la value de l'heure de retour//
    let nouveauHeureRetour = document.getElementById("heureR").value

    //Récupérer la value des km parcourus//
    let nouveauKm = document.getElementById("km").value

    //Récupérer la value de météo//
    let nouveauMeteo = selectMeteo.value

    //Récupérer les values des routes + transformer en tableau//
    let routeOptions = selectRoute.selectedOptions;
    let nouveauRoute = Array.from(routeOptions).map(option => option.value);

    //Récupérer la value du trafic//
    let nouveauTrafic = selectTrafic.value

    //Récupérer les values des manoeuvres + transformer en tableau
    let manoeuvreOptions = selectManoeuvre.selectedOptions;
    let nouveauManoeuvre = Array.from(manoeuvreOptions).map(option => option.value);

    //On définit d'abord les bons formats pour les dates//
    nouveauDepart = new Date(nouveauDepart)
    let nouveauDepartString = nouveauDepart.toISOString().split('T')[0];
    let nouveauHeureDepartString = nouveauHeureDepart + ':00.000Z';
    let heureDepart = nouveauDepartString + 'T' + nouveauHeureDepartString

    nouveauRetour = new Date(nouveauRetour)
    let nouveauRetourString = nouveauRetour.toISOString().split('T')[0];
    let nouveauHeureRetourString = nouveauHeureRetour + ':00.000Z';
    let heureFin = nouveauRetourString + 'T' + nouveauHeureRetourString

    //On donne le format d'un nouveau trajet
    const nouveauTrajet = {
        "idTrajet":compteur,
        "duree":{
            "heureDepart":heureDepart,
            "heureFin":heureFin
        },
        "kilometres":nouveauKm,
        "conditions":
        {
            "idConditionMeteo":nouveauMeteo,
            "idTypeRoute":nouveauRoute,
            "idTypeTraffic":nouveauTrafic
        },
        "manoeuvres":nouveauManoeuvre
    }

    //On l'ajoute au tableau de listeTrajets, défini avant la fonction
    listeTrajets.push(nouveauTrajet)
    
    //Ici, c'est l'enregistrement dans le localstorage
    const listeTrajetsJSON = JSON.stringify(listeTrajets)
    localStorage.setItem('trajets', listeTrajetsJSON) //On les enregistre dans le localstorage
})

//Afficher l'avancée en km//
let affichageNumeroFiche = document.querySelector("h2")
affichageNumeroFiche.textContent = "Ma sortie conduite accompagnée numéro #" + compteur

//Faire un tableau récapitulatif des derniers trajets
//On commence par définir les variables qui auront les différents éléments
let creationTableau = document.getElementById("afficherRecap")
let tableau = document.createElement("table")
let entete = document.createElement("tr")

//Besoin de faire un tableau de correspondance//
let tableauEntete = ["Trajet", "Jour", "Durée", "Distance"]

tableauEntete.forEach(function(propriete){
    let celluleEnTete = document.createElement("th");
    celluleEnTete.textContent = propriete;
    entete.appendChild(celluleEnTete);
})



//Ici je mets un séparateur pour le récapitulatif des expériences
let ligneRecap = document.createElement("tr")
let celluleRecap = document.createElement("td")
celluleRecap.textContent = 'Avancée générale'
celluleRecap.setAttribute('colspan', tableauEntete.length)
ligneRecap.classList.add('ligne-recapitulatif')
ligneRecap.appendChild(celluleRecap)
tableau.appendChild(ligneRecap)    

let totalMillisecondes = 0 //Permet de savoir combien d'heure de conduite ont été réalisées

listeTrajets.forEach(function(trajet){ //On fait une ligne récap en haut du tableau
    let heureDepart = new Date(trajet.duree.heureDepart)
    let heureFin = new Date(trajet.duree.heureFin)
    let differenceMillisecondes = heureFin - heureDepart
    totalMillisecondes += differenceMillisecondes
})

let ligneRecapContent = document.createElement("tr") //Début du calcul des heures de conduites réalisées, on va récupérer les heures et minutes
let totalHeure = Math.floor(totalMillisecondes / 3600000) 
totalMillisecondes %= 3600000
let totalMinutes = Math.floor(totalMillisecondes / 60000)

let celluleRecapKm = document.createElement("td") //Ajout de la cellule pour montrer les km
celluleRecapKm.textContent= totalKm + "km" 
celluleRecapKm.setAttribute('colspan', tableauEntete.length/2)

let celluleRecapDuree = document.createElement("td") //Ajout de la cellule pour montrer le temps conduit
celluleRecapDuree.textContent = totalHeure + "h " + totalMinutes + "min" 
celluleRecapDuree.setAttribute('colspan', tableauEntete.length/2)

ligneRecapContent.appendChild(celluleRecapDuree)
ligneRecapContent.appendChild(celluleRecapKm)

tableau.appendChild(ligneRecapContent) 

tableau.appendChild(entete)

listeTrajets.reverse() //On veut afficher les plus récentes en premier

listeTrajets.forEach(function(trajet){//La on fait le détail de chaque trajet

    //On récupère l'ID//
    let ligne = document.createElement("tr")
    let celluleIdTrajet = document.createElement("td")
    celluleIdTrajet.textContent = trajet.idTrajet
    ligne.appendChild(celluleIdTrajet)
    
    //On récupère la date de départ//
    let celluleJourDepart = document.createElement("td")
    let valeurJourDepart = new Date(trajet.duree.heureDepart)
    let jourDepart = valeurJourDepart.getDate()
    let moisDepart = valeurJourDepart.getMonth()+1
    let anneeDepart = valeurJourDepart.getFullYear()
    celluleJourDepart.textContent = jourDepart + "/" + moisDepart + "/" + anneeDepart
    ligne.appendChild(celluleJourDepart)


    //On récupère et calcule la durée du trajet//
    let celluleDuree = document.createElement("td")
    let calculDepart = new Date(trajet.duree.heureDepart)
    let calculRetour = new Date(trajet.duree.heureFin)
    let differenceMillisecondes = calculRetour - calculDepart
    let heure = Math.floor(differenceMillisecondes / 3600000)
    differenceMillisecondes %= 3600000
    let minutes = Math.floor(differenceMillisecondes / 60000)
    differenceMillisecondes %= 60000
    let secondes = Math.floor(differenceMillisecondes / 1000)
    if (heure > 0){
        celluleDuree.textContent = heure + "h " + minutes + "min " + secondes + "s"
    } else {
        celluleDuree.textContent = minutes + "min " + secondes + "s"
    }
    ligne.appendChild(celluleDuree)

    
    //On récupère les km parcourus//
    let celluleKm = document.createElement("td")
    celluleKm.textContent = trajet.kilometres + "km"
    ligne.appendChild(celluleKm)


    tableau.appendChild(ligne)
})

 

creationTableau.appendChild(tableau)

if(localStorage.getItem('trajets') !== null){
    creationTableau.classList.add("afficherRecap")
    creationTableau.classList.remove("hidden")
}

}