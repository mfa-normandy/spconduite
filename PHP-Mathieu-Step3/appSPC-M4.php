<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=David+Libre:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <script>
        window.onload = function() {
        // format storage // let listeTrajets = [{"idTrajet":1,"duree":{"heureDepart":"2024-03-05T15:00:00.000Z","heureFin":"2024-03-05T16:00:00.000Z"},"kilometres":123,"conditions":{"idConditionMeteo":3,"idTypeRoute":2,"idTypeTraffic":1},"manoeuvres":[0,1]},{"idTrajet":2,"duree":{"heureDepart":"2024-03-06T15:00:00.000Z","heureFin":"2024-03-06T16:00:00.000Z"},"kilometres":107,"conditions":{"idConditionMeteo":1,"idTypeRoute":1,"idTypeTraffic":1},"manoeuvres":[2]}];//variables
        let meteo = [{"meteoId":1,"temps":"Clair"},{"meteoId":2,"temps":"Nuageux"},{"meteoId":3,"temps":"Couvert"},{"meteoId":4,"temps":"Pluvieux"},{"meteoId":5,"temps":"Brumeux"},{"meteoId":6,"temps":"Neigeux"},{"meteoId":7,"temps":"Orageux"},{"meteoId":8,"temps":"Tempetueux"}];
        let typeRoute = [{"typeRouteId":1,"typeRouteNom":"Nationale"},{"typeRouteId":2,"typeRouteNom":"Départementale"},{"typeRouteId":3,"typeRouteNom":"Autoroute"},{"typeRouteId":4,"typeRouteNom":"Centre-ville"},{"typeRouteId":5,"typeRouteNom":"Mixte"}];
        let typeTraffic = [{"traficId":1,"typeTrafic":"Faible"},{"traficId":2,"typeTrafic":"Modéré"},{"traficId":3,"typeTrafic":"Fort"},{"traficId":4,"typeTrafic":"Fluctuant"}];
        let manoeuvres = [{"manoeuvreId":1,"manoeuvreNom":"Stationnement en épi"},{"manoeuvreId":2,"manoeuvreNom":"Stationnement en bataille"},{"manoeuvreId":3,"manoeuvreNom":"Stationnement en créneau"}];    
        
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

    //console.log(trajetParse)

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
            let affichageAvancee = document.querySelector('aside')
            let nouveauTotalKm = document.createElement("p")
            nouveauTotalKm.textContent = "Félicitations, vous avez déjà conduit " + totalKm + "km ! Plus que " + objectifKmRestant + " à parcourir !"
            nouveauTotalKm.id = "TotalKm"
            affichageAvancee.appendChild(nouveauTotalKm)
        } 

        let compteur = listeTrajets.length+1
    //Pour insérer des éléments dans le localStorage, il faut prendre le formulaire
    var formulaire = document.getElementById("formulaire"); //On récupère le formulaire

    //Fonction pour ajouter des éléments dans le localStorage
    formulaire.addEventListener('submit', (event) => {
    event.preventDefault();
    
        
        // Handler de la requete à l'API Open AI
        var oaipass = document.getElementById("oaipass").value;
        var prompt = document.getElementById("prompt").value;
        
        $.ajax({
    url: 'https://api.openai.com/v1/threads/runs',
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + oaipass,
        'OpenAI-Beta': 'assistants=v1',
    },
    data: JSON.stringify({
        "assistant_id": "asst_rxdHY63u4Z1NToF7zD8ae2Nr",
        "thread": {
            "messages": [{
                "role": "user",
                "content": "here is the data you will analyze:" + enregistrementLocalStorage + " " + prompt + " Please when you plot the data to represent a dimension, don't display the id but rather the name of the dimension, thaa I give you here after :" + JSON.stringify(meteo) + JSON.stringify(typeRoute) + JSON.stringify(typeTraffic) + JSON.stringify(manoeuvres)
            }]
        }
    }),
    responseType: 'json',
    success: function(data) {
        //console.log(data);
        // On récupère le message de réponse
        // On extrait la valeur de la clé "status" du message de réponse
        var status = data.status;
        var threadId = data.thread_id;
        var runId = data.id;
        document.getElementById("response").innerHTML = "<br><br> Bien joué votre requête OpenAI API est:" + status + ", <br> votre diagramme est en cours de construction. <div style=\"text-align:center;\"><img src='./ld.gif' alt='diagramme' width='70' height='70'></div>";
        // Create a function that calls sendRequest with the necessary arguments
        var sendRequestWithArgs = function() {
            sendRequest(threadId, runId, oaipass, intervalId);
        // Call sendRequestWithArgs every 7000 milliseconds (7 seconds)
        };
        var intervalId = setInterval(sendRequestWithArgs, 7000);
    },
    error: function(error) {
        console.log('Error:', error);
    }
    });
    
    ////essaie de récupérer l'image toutes les 5 secondes
    function sendRequest(thread_id,run_id,oai_pass,interval_id) {
        $.ajax({
            url: 'https://api.openai.com/v1/threads/' + thread_id + '/runs/' + run_id,
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + oai_pass,
                'OpenAI-Beta': 'assistants=v1',
            },
            responseType: 'json',
            success: function(data) {
                //console.log(data);
                //console.log(data.status);
                // Check if the data is 'complete'
                if (data.status === 'completed') {
                    // If it is, stop the interval
                       clearInterval(interval_id);
                       var imageId = getImageId(thread_id, oai_pass);
                       //console.log(imageId);
                         }
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    }
    
    

    function getImageId(thread_id, oai_pass) {

        $.ajax({
            url: 'https://api.openai.com/v1/threads/' + thread_id + '/messages',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + oai_pass,
                'OpenAI-Beta': 'assistants=v1',
                'Accept': 'application/json',
                'Response-Type': 'json'
            },
            success: function(data) {
                try {
                    var imageFileId = data.data[0].content[0].image_file.file_id;
                    var gptText = data.data[0].content[1].text.value;
                    //console.log(imageFileId);
                    getImageFile(imageFileId, oai_pass, gptText);
                    return imageFileId;
                } catch (error) {
                    document.getElementById("response").innerHTML = "<br><br>Navrés mais notre chatbot n'a pas compris votre requête, veuillez reformuler votre demande et utiliser de préferrence l'anglais.";
                    console.log('Error:', error);
                }
                
            },
            error: function(error) {
                document.getElementById("response").innerHTML = "<br><br>Navrés mais notre chatbot n'a pas réponsu, veuillez réessayer plus tard ou vérifier votre pass API et vos crédits.";
                console.log('Error:', error);
            }
        });
    }

        function getImageFile(image_id, o_ai_pass, gpt_text) {
            $.ajax({
                url: 'https://api.openai.com/v1/files/' + image_id + '/content',
                method: 'GET',
                headers: {
                    'Content-Type': 'application/octet-stream',
                    'Authorization': 'Bearer ' + o_ai_pass,
                    'OpenAI-Beta': 'assistants=v1',
                },
                xhrFields: {
                responseType: 'blob'
                                     },
                success: function(data) {
                    //console.log(data);
                    // Use FileSaver.js to save the blob as chart.png
                    saveAs(data, "chart.png", {type: 'application/octet-stream'});
                    
                    // Create a Blob URL from the data
                    var url = URL.createObjectURL(data);

                    // Set the src attribute of the img tag to the Blob URL
                    document.getElementById("response").innerHTML = '<br>' + gpt_text+ '<br><br><img src="' + url + '" alt="diagramme" width="400px">';
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
   });

}
</script>
<script src="https://unpkg.com/react@16/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone@7.24.4/babel.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/react-vis/dist/style.css">
    <script type="text/javascript" src="https://unpkg.com/react-vis/dist/dist.min.js"></script>

    <script type="text/babel">
        const {
            ArcSeries,
            AreaSeries,
            DiscreteColorLegend,
            VerticalBarSeries, 
            RadialChart,
            LabelSeries,
            XYPlot,
            HorizontalGridLines,
            LineSeries,
            FlexibleXYPlot,
            XAxis,
            YAxis
        } = reactVis

    //Premier essai : un tableau permettant de visualiser les km parcourus par trajet
    function ChartKm({dataKm}) {
        // Permet de trouver et définir la valeur max d'Y
        const maxYValue = Math.max(...dataKm.map(point => point.y))
        const maxXValue = Math.max(...dataKm.map(point => point.x))
        // On doit définir l'écart de valeur de yDomain (0 à valeur max)
        const yDomain = [0, maxYValue]
        const xDomain = [1, maxXValue]
        const xValues = dataKm.map(bar => bar.x);
        console.log('xValues')
        console.log(xValues)
        dataKm = dataKm.map(bar => ({...bar, x: `${bar.x}`}))

        return (
            <div>
                <h2>Visualisation des kilomètres réalisés par trajets</h2>
                <XYPlot
                    width={400}
                    height={400}
                    yDomain={yDomain} //On réutilise la const yDomain pour définir l'étendu du tableau
                    //xDomain={xDomain}
                    xType='ordinal'
                    >
                    <HorizontalGridLines />
                   
                    <XAxis />
                    <YAxis />
                    {dataKm.map((bar,index) => (
                            <VerticalBarSeries key={bar.x} data={[{x: bar.x, y: bar.y}]} color={bar.color} barWidth={1} />
                        ))}
                </XYPlot>
                
                
            </div>
        )
        }

    let listeTrajetsVisualisation = JSON.parse(localStorage.getItem('trajets'))

    let dataKm = []; //Il s'agit de la constante qui va stocker les objets km avec les id associés
    //On définit ensuite les variables qui stockent les x et les y (id et km)
    let localStorageKm = []
    let localStorageId = []
    
    listeTrajetsVisualisation.forEach(function(trajet){
        localStorageKm.push(trajet.kilometres) 
    })

    listeTrajetsVisualisation.forEach(function(trajet){
        localStorageId.push(trajet.idTrajet)
    })
    
    console.log("Storage Data")
    console.log(localStorageKm)
    console.log(localStorageId)

    
    for(let index=0 ; index < (localStorageKm.length); index++){ //On va ajouter chaque valeur km pour faire le tableau
        const ajout= {
            x:localStorageId[index],
            y:localStorageKm[index],
            color:'#214EA8'
        }
        dataKm.push(ajout)
    }

    dataKm=dataKm.sort((a, b) => a.x - b.x); //permet de trier dans l'ordre les entrées pour éviter d'avoir une confusion et plusieurs lignes
    console.log("Sorted Data")
    console.log(dataKm)

    const chartKm = <ChartKm dataKm={dataKm} />
    ReactDOM.render(chartKm, document.querySelector('#root-km')) //Endroit où on envoie le graphique des km parcourus

    //Premier essai BIS : un tableau permettant de visualiser les km aggrégés avec target a 3000km
    function ChartKmAgg({dataKmAgg}) {
        // Permet de trouver et définir la valeur max d'Y
        const maxYValue = Math.max(...dataKmAgg.map(point => point.y))
        
        // On doit définir l'écart de valeur de yDomain (0 à valeur max)
        
        const kmToReach = 3000; // Replace this with the amount of km to reach
        const yDomain = [0, kmToReach +100]
        return (
            <div>
                <h2>Visualisation des kilomètres réalisés au total, objectif: 3000km</h2>
                <XYPlot width={400} height={300} yDomain={yDomain}>
                    <HorizontalGridLines color="blue" tickValues={[kmToReach]} />
                <XAxis />
                <YAxis />
                <AreaSeries
                    className="area-series-example"
                    curve="curveNatural"
                    data={dataKmAgg}
                    color="#00A288" // Change this to the color you want
                />
                </XYPlot>
            </div>
        )
        }

    listeTrajetsVisualisation = JSON.parse(localStorage.getItem('trajets'))

    const dataKmAgg = []; //Il s'agit de la constante qui va stocker les objets km avec les id associés
    //On définit ensuite les variables qui stockent les x et les y (id et km)
    let localStorageKmAgg = []
    let localStorageIdAgg = []
    

    listeTrajetsVisualisation.forEach(function(trajet){
        localStorageKmAgg.push(trajet.kilometres) 
    })

    listeTrajetsVisualisation.forEach(function(trajet){
        localStorageIdAgg.push(trajet.idTrajet) 
    })

    //console.log(localStorageKmAgg)
    //console.log(localStorageIdAgg)
    
    //remets le tableau de kilometrage dans l'ordre car le storage est random en terme d'array id
    let combinedArray = localStorageKmAgg.map((km, index) => ({
    kmAgg: km,
    idAgg: localStorageIdAgg[index]
     }));

     combinedArray= combinedArray.sort((a, b) => a.idAgg - b.idAgg); 
    localStorageKmAgg = combinedArray.map(item => item.kmAgg);
    
    console.log('localStorageKmAgg')
    console.log(localStorageKmAgg)

    //Crée la donnée a afficher
    for(let index=0 ; index < localStorageKmAgg.length; index++){ //On va ajouter chaque valeur km pour faire le tableau
        if(index==0){
            const ajout= {
                x:index,
                y:Number(localStorageKmAgg[index])
            }
            dataKmAgg.push(ajout)
        } else {
            const ajout= {
                x:index,
                y:Number(localStorageKmAgg[index])+Number(dataKmAgg[index-1].y)
            }
            dataKmAgg.push(ajout)
        }
        
    }

    console.log('dataKmAgg')
    console.log(dataKmAgg)
    
    //appel du chart
    const chartKmAgg = <ChartKmAgg dataKmAgg={dataKmAgg} />
    ReactDOM.render(chartKmAgg, document.querySelector('#root-kmAgg')) //Endroit où on envoie le graphique des km parcourus

    //Deuxième essai : visualiser le nombre de trajet réalisés par différentes conditions de stationnement

        function ChartStationnement({data}) {
        return (
            <div style={{width: '400px', height: '300px'}}>
                <h2>Les exercices de stationnement réalisés</h2>
                <RadialChart
                data={datastationnement}
                width={400}
                height={280}  >
                    <DiscreteColorLegend 
                            orientation="horizontal"
                            items={[
                                {title: `Stationnement en epi : ${localStorageStationnementEpi}`, color: '#214EA8'},
                                {title: `Stationnement en bataille : ${localStorageStationnementBataille}`, color: '#00A288'}
                            ]}
                    />
                    <DiscreteColorLegend 
                            orientation="horizontal"
                            items={[
                                {title: `Stationnement en créneau : ${localStorageStationnementCreneau}`, color: '#29C62F'}
                            ]}
                    />
                    <ArcSeries 
                        data={datastationnement} 
                        colorDomain={[0, 1, 2, 3, 4, 5, 6]} 
                        colorRange={['#214EA8', '#00A288', '#29C62F']} 
                        colorType='linear'
                        />
                        <LabelSeries data={datastationnement.map(item => ({ ...item, label: item.label }))} />     
                </RadialChart>
            </div>
        )
        }

        let localStorageStationnementEpi=0
        let localStorageStationnementBataille=0
        let localStorageStationnementCreneau=0

        listeTrajetsVisualisation.forEach(function(trajet){
            if(trajet.manoeuvres.includes('1')){
                localStorageStationnementEpi++
            }
            if(trajet.manoeuvres.includes('2')){
                localStorageStationnementBataille++
            }
            if(trajet.manoeuvres.includes('3')){
                localStorageStationnementCreneau++
            }
        })
        
        //console.log(localStorageStationnementEpi)
        //console.log(localStorageStationnementBataille)
        //console.log(localStorageStationnementCreneau)

        const totalStationnement = localStorageStationnementEpi + localStorageStationnementBataille + localStorageStationnementCreneau
        const camembertRadius = 100

        const datastationnement = [
            {
                angle0: 0,
                angle: (localStorageStationnementEpi / totalStationnement) * (Math.PI * 2),
                radius: camembertRadius,
                color: 0,
            },
            {
                angle0: (localStorageStationnementEpi / totalStationnement) * (Math.PI * 2),
                angle: ((localStorageStationnementEpi + localStorageStationnementBataille) / totalStationnement) * (Math.PI * 2),
                radius:camembertRadius,
                color: 1,
            },
            {
                angle0: ((localStorageStationnementEpi + localStorageStationnementBataille) / totalStationnement) * (Math.PI * 2),
                angle: Math.PI * 2,
                radius: camembertRadius,
                color: 2,
            }
        ]

        const chartStationnement = <ChartStationnement data={datastationnement}/>
        ReactDOM.render(chartStationnement, document.querySelector('#root-stationnement'))

        //Troisième essai  : visualiser les données type de route
        function ChartTypeRoute({data}){
            return (
                <div>
                    <h2>Tableau présentant le nombre de fois où des types de routes ont été parcourus</h2>
                    <XYPlot
                        width={400}
                        height={300}>
                        <DiscreteColorLegend 
                            orientation="horizontal"
                            items={[
                                {title: `Nationale : ${localStorageRouteNationale}`, color: '#214EA8'},
                                {title: `Departementale : ${localStorageRouteDepartementale}`, color: 'green'},
                                {title: `Autoroute : ${localStorageRouteAutoroute}`, color: '#00A288'}
                            ]}
                        />
                        <DiscreteColorLegend 
                            orientation="horizontal"
                            items={[
                                {title: `Centre-ville : ${localStorageRouteCentre}`, color: '#00879A'},
                                {title: `Route mixte : ${localStorageRouteMixte}`, color: '#29C62F'}
                            ]}
                        />
                        <HorizontalGridLines />
                        <YAxis />
                        {data.map((bar, index) => (
                            <VerticalBarSeries key={index} data={[bar]} color={bar.color} barWidth={0.5} />
                        ))}
                    </XYPlot>
                </div>
        )}

        let localStorageRouteNationale=0
        let localStorageRouteDepartementale=0
        let localStorageRouteAutoroute=0
        let localStorageRouteCentre=0
        let localStorageRouteMixte=0

        listeTrajetsVisualisation.forEach(function(trajet){
            if(trajet.conditions.idTypeRoute.includes('1')){
                localStorageRouteNationale++
            }
            if(trajet.conditions.idTypeRoute.includes('2')){
                localStorageRouteDepartementale++
            }
            if(trajet.conditions.idTypeRoute.includes('3')){
                localStorageRouteAutoroute++
            }
            if(trajet.conditions.idTypeRoute.includes('4')){
                localStorageRouteCentre++
            }
            if(trajet.conditions.idTypeRoute.includes('5')){
                localStorageRouteMixte++
            }
        })

        const data = [
            {x: 1, y: localStorageRouteNationale, color:'#214EA8'},
            {x: 2, y: localStorageRouteDepartementale, color:'green'},
            {x: 3, y: localStorageRouteAutoroute, color:'#00A288'},
            {x: 4, y: localStorageRouteCentre, color:'#00879A'},
            {x: 5, y: localStorageRouteMixte, color:'#29C62F'}
        ]

        const chart = <ChartTypeRoute data={data}/>
        ReactDOM.render(chart, document.querySelector('#root-route'))

        //Quatrième : on fait la météo//

        function ChartTypeMeteo({data}){
            return (
                <div>
                    <h2>Tableau présentant le nombre d'expériences de conduites sous différentes conditions météo</h2>
                    <XYPlot
                        width={400}
                        height={300}
                        cluster={'bar'}>
                        <DiscreteColorLegend 
                            orientation="horizontal"
                            items={[
                                {title: `Clair : ${localStorageMeteoClair}`, color: '#214EA8'},
                                {title: `Nuageux : ${localStorageMeteoNuageux}`, color: 'green'},
                                {title: `Couvert : ${localStorageMeteoCouvert}`, color: '#08C6E0'},
                                {title: `Pluvieux : ${localStorageMeteoPluvieux}`, color: '#00A288'}
                            ]}
                        />
                        <DiscreteColorLegend 
                            orientation="horizontal"
                            items={[
                                {title: `Brumeux : ${localStorageMeteoBrumeux}`, color: '#086AE0'},
                                {title: `Neigeux : ${localStorageMeteoNeigeux}`, color: '#00879A'},
                                {title: `Orageux : ${localStorageMeteoOrageux}`, color: '#22E09A'},
                                {title: `Tempetueux : ${localStorageMeteoTempetueux}`, color: '#29C62F'}
                            ]}
                        />
                        <HorizontalGridLines />
                        <YAxis />
                        {dataMeteo.map((bar, index) => (
                            <VerticalBarSeries key={index} data={[bar]} color={bar.color} barWidth={0.6} />
                        ))}
                    </XYPlot>
                </div>
        )}

        let localStorageMeteoClair=0
        let localStorageMeteoNuageux=0
        let localStorageMeteoCouvert=0
        let localStorageMeteoPluvieux=0
        let localStorageMeteoBrumeux=0
        let localStorageMeteoNeigeux=0
        let localStorageMeteoOrageux=0
        let localStorageMeteoTempetueux=0

        listeTrajetsVisualisation.forEach(function(trajet){
            if(trajet.conditions.idConditionMeteo == 1){
                localStorageMeteoClair++
            }
            if(trajet.conditions.idConditionMeteo == 2){
                localStorageMeteoNuageux++
            }
            if(trajet.conditions.idConditionMeteo == 3){
                localStorageMeteoCouvert++
            }
            if(trajet.conditions.idConditionMeteo == 4){
                localStorageMeteoPluvieux++
            }
            if(trajet.conditions.idConditionMeteo == 5){
                localStorageMeteoBrumeux++
            }
            if(trajet.conditions.idConditionMeteo == 6){
                localStorageMeteoNeigeux++
            }
            if(trajet.conditions.idConditionMeteo == 7){
                localStorageMeteoOrageux++
            }
            if(trajet.conditions.idConditionMeteo == 8){
                localStorageMeteoTempetueux++
            }
        })

        const dataMeteo = [
            {x: 1, y: localStorageMeteoClair, color:'#214EA8'},
            {x: 2, y: localStorageMeteoNuageux, color:'green'},
            {x: 3, y: localStorageMeteoCouvert, color:'#08C6E0'},
            {x: 4, y: localStorageMeteoPluvieux, color:'#00A288'},
            {x: 5, y: localStorageMeteoBrumeux, color:'#086AE0'},
            {x: 6, y: localStorageMeteoNeigeux, color:'#00879A'},
            {x: 7, y: localStorageMeteoOrageux, color:'#22E09A'},
            {x: 8, y: localStorageMeteoTempetueux, color:'#29C62F'}
        ]

        const chartMeteo = <ChartTypeMeteo data={data}/>
        ReactDOM.render(chartMeteo, document.querySelector('#root-meteo'))

        //Cinquième : les types de trafic//

        function ChartTrafic({data}) {
        return (
            <div>
                <h2>Les exercices de stationnement réalisés</h2>
                <RadialChart
                data={datastationnement}
                width={400}
                height={300}>
                    <DiscreteColorLegend 
                            orientation="horizontal"
                            items={[
                                {title: `Trafic faible : ${localStorageTraficFaible}`, color: '#214EA8'},
                                {title: `Trafic modéré : ${localStorageTraficModere}`, color: '#00A288'}
                            ]}
                        />
                        <DiscreteColorLegend 
                            orientation="horizontal"
                            items={[
                                {title: `Trafic fort : ${localStorageTraficFort}`, color: '#29C62F'},
                                {title: `Trafic fluctuant : ${localStorageTraficFluctuant}`, color: '#52EA00'}
                            ]}
                        />
                    <ArcSeries 
                        data={data} 
                        colorDomain={[0, 1, 2, 3, 4, 5, 6]} 
                        colorRange={['#214EA8', '#00A288', '#29C62F']} 
                        colorType='linear'
                        />
                        
                </RadialChart>
            </div>
        )
        }

        let localStorageTraficFaible=0
        let localStorageTraficModere=0
        let localStorageTraficFort=0
        let localStorageTraficFluctuant=0

        listeTrajetsVisualisation.forEach(function(trajet){
            if(trajet.conditions.idTypeTraffic == '1'){
                localStorageTraficFaible++
            }
            if(trajet.conditions.idTypeTraffic == '2'){
                localStorageTraficModere++
            }
            if(trajet.conditions.idTypeTraffic == '3'){
                localStorageTraficFort++
            }
            if(trajet.conditions.idTypeTraffic == '4'){
                localStorageTraficFluctuant++
            }
        })
    

        const totalTrafic = localStorageTraficFaible + localStorageTraficModere + localStorageTraficFort + localStorageTraficFluctuant

        const datatrafic = [
            {
                angle0: 0,
                angle: (localStorageTraficFaible / totalTrafic) * Math.PI * 2,
                radius: camembertRadius,
                color: 0,
            },
            {
                angle0: (localStorageTraficFaible / totalTrafic) * Math.PI * 2,
                angle: ((localStorageTraficFaible + localStorageTraficModere) / totalTrafic) * Math.PI * 2,
                radius: camembertRadius,
                color: 1,
            },
            {
                angle0: ((localStorageTraficFaible + localStorageTraficModere) / totalTrafic) * Math.PI * 2,
                angle: ((localStorageTraficFaible + localStorageTraficModere + localStorageTraficFort) / totalTrafic) * Math.PI * 2,
                radius: camembertRadius,
                color: 2,
            },
            {
                angle0: ((localStorageTraficFaible + localStorageTraficModere + localStorageTraficFort) / totalTrafic) * Math.PI * 2,
                angle: Math.PI * 2,
                radius: camembertRadius,
                color: 3,
            }
        ]

        const chartTrafic = <ChartTrafic data={datatrafic}/>;
        ReactDOM.render(chartTrafic, document.querySelector('#root-trafic'));

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
            <a href="connectDBclass.inc.php?login=1"><span id="login">Log In</span></a>
            </div>
            <div>
                <a href="appSPC-M2.php"><span id="newsheet"><strong> Créer une fiche de conduite</strong></span></a>
            </div>
            <div>
                <span id="stats">Dashboard stastistiques</span>
            </div>
        </div>
    </nav>
    <aside>
        <img id="resp-400-image" src="./car.png" alt="Logo" width="400" height="120">
        
        <h1>Résumé de vos experiences de conduite</h1>
    </aside>
    <article>
        
        <section class="root">
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
        <br><br><br><br><br><br><br><br>
        <h2>Demandez a notre de bot de visualisation de construire vos diagrammes personnalisés! </h2>
        <p> Example : je veux voir la proportion de chaque condition meteo sur l'ensemble des trajets sous forme de camembert.<br></p>
        <p> Pour cela, veuillez remplir et envoyer le formulaire ci-dessous avec votre souhait de visualisation.</p>
        <!--EMPLACEMENT DU CODE OPENAI-->
      

        <form id="formulaire">
            
            <fieldset id="promptfs" class="form-grid">
                <label for="oaipass">Votre passkey OpenAI API</label>
                <input value="" type="text" id="oaipass" name="oaipass" required>
                <label for="prompt">Mes statistiques personnalisées avec Chat GPT 3.5</label>
                <textarea id="prompt" name="prompt" required rows="10" cols="50">please highlight the percentage of trips per idConditionMeteo in a piechart</textarea>
            </fieldset>
            
            <div class="no-grid">
                <br>
                <input type="submit" value="Envoyer">
                <br>
            </div>
            </form>
            
            <div id="response"></div>
            
        </article>
          
        <!--FIN         DU CODE OPENAI-->
        <section>

        </section>
        <footer>
            <div id="contactCell"><span>Uniconduite <br><br>
                Copyright 2024 - UNISTRA<br> <a href="mailto:info@ecoleoscar.com">info@uniconduite.com</a></span>
            </div>
        </footer>
    </body>
    </html>
