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
            width={300}
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
        <XYPlot width={300} height={300} yDomain={yDomain}>
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
    <div style={{width: '300px', height: '300px'}}>
        <h2>Les exercices de stationnement réalisés</h2>
        <RadialChart
        data={datastationnement}
        width={300}
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
                width={300}
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
                width={300}
                height={300}
                cluster={'bar'}>
                <DiscreteColorLegend 
                    orientation="horizontal"
                    items={[
                        {title: `Clair : ${localStorageMeteoClair}`, color: '#214EA8'},
                        {title: `Nuageux : ${localStorageMeteoNuageux}`, color: 'green'},
                        {title: `Couvert : ${localStorageMeteoCouvert}`, color: '#08C6E0'}
                        
                    ]}
                />
                <DiscreteColorLegend 
                    orientation="horizontal"
                    items={[
                        {title: `Pluvieux : ${localStorageMeteoPluvieux}`, color: '#00A288'},
                        {title: `Brumeux : ${localStorageMeteoBrumeux}`, color: '#086AE0'},
                        {title: `Neigeux : ${localStorageMeteoNeigeux}`, color: '#00879A'}
                    ]}
                />
                <DiscreteColorLegend 
                    orientation="horizontal"
                    items={[
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
        width={300}
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