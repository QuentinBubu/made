<?php
//Type mime de l'image
//header('Content-type: image/png');
//Importation de la class crée
require_once 'Graph.php';
//Récupération des valeurs
$data = json_decode($_GET['data'], true);
$temp = $data['temp'];
$rain = $data['rain'];
$wind = $data['wind'];
$date = $data['date'];
$hour = $data['hour'];
/*Création d'un tableau all qui contiendra les données sous cet ordre
*all = [
    [0]=>
        array(4) {
            [0]=>
            string(X) "X"
            [1]=>
            string(X) "X"
            [2]=>
            string(X) "X"
            [3]=>
                string(X) "YYYY-MM-DD HH:MM:00.000000"
        }
    ]
]
*/
$all = [];
for ($i = 0; $i < count($temp); $i++) {
    //On mets dans all les informations tout en créant un tableau
    $all[$i] = [$temp[$i], $rain[$i], $wind[$i], date($date[$i] . ' ' . $hour[$i])];
}
$columns = array_column($all, 3); //Séléction des lignes date
array_multisort($columns, SORT_ASC, $all, $temp, $rain, $wind); // Mise dans l'ordre croissant des tableaux

$type = $_GET['type'];
if ($type === 'temp') {
    $graphique = new Graph($all, $temp, $date);
    $graphique->getNewPointGraph();
    $graphique->getGenerateImage();
} elseif ($type === 'wind') {
    $graphique = new Graph($all, $wind, $date);
    $graphique->getNewPointGraph();
    $graphique->getGenerateImage();
} elseif ($type === 'rain') {
    $graphique = new Graph($all, $rain, $date);
    $graphique->getNewBarreGraph();
    $graphique->getGenerateImage();
}