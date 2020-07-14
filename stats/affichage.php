<?php
// L'on vérifie que tout les champs sont présents et aucun supprimer en utilisant la fonction count pour les contés et voir si il y en a le même nombre
if (
    count($_POST['temp'])
    !== count($_POST['rain'])
    || count($_POST['rain'])
    !== count($_POST['wind'])
    || count($_POST['wind'])
    !== count($_POST['date'])
    || count($_POST['date'])
    !== count($_POST['hour']) 
) {
    ?>
    <script>
    //Si il manque des champs, on affiche une alerte suivi d'une redirection
    alert('Des champs ont été supprimés, veuillez recommencer!');
    document.location.href="index.html";
    </script>
    <?php
}
//On parcourt le tableau multidimensionnel POST
foreach ($_POST as $arrays) {
    //On parcourt les tableaux dans POST
    foreach ($arrays as $value) {
        if (empty($value)) {
            ?>
            <script>
            //Si des champs n'ont pas été saisis et contourné le required, on affiche une alert suivi d'une redirection
            alert('Veuillez saisir tout les champs!');
            document.location.href="index.html";
            </script>
            <?php
        }
    }
}
//On assigne les tableaux
$temp = $_POST['temp'];
$rain = $_POST['rain'];
$wind = $_POST['wind'];
$date = $_POST['date'];
$hour = $_POST['hour'];

//Si la personne à cochée la case "sauvegarder sur JSON"
if (isset($_POST['json'])) {
    //Récupération des données JSON
    $json = json_decode(file_get_contents('data.json'), true);
    //Fusion des tableaux avec array_merge
    $temp = $_POST['temp'] = array_merge($temp, $json['temp']);
    $rain = $_POST['rain'] = array_merge($rain, $json['rain']);
    $wind = $_POST['wind'] = array_merge($wind, $json['wind']);
    $date = $_POST['date'] = array_merge($date, $json['date']);
    $hour = $_POST['hour'] = array_merge($hour, $json['hour']);
    //Régénération d'un tableau pour la sauvegarde JSON
    $json =
    [
        'temp' => $temp,
        'rain' => $rain,
        'wind' => $wind,
        'date' => $date,
        'hour' => $hour
    ];
    //Sauvegarde JSON
    file_put_contents('data.json', json_encode($json));
}

$all = [];
for ($i = 0; $i < count($temp); $i++) {
    //On mets dans all les informations tout en créant un tableau
    $all[$i] = [$temp[$i], $rain[$i], $wind[$i], date($date[$i] . ' ' . $hour[$i])];
}
$columns = array_column($all, 3); //Séléction des lignes date
array_multisort($columns, SORT_DESC, $all); //Mise dans l'ordre croissant des tableaux
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Graphiques</title>
</head>

<body>
    <section id="graphs">
        <!--
            Génération des images, passages des données de POST via url;
            Vous remarquerz qu'un span entoure chaque image, c'est pour éviter le redimentionnement
        -->
        <span>
            <img
                src="generate.php?type=temp&data=<?= urlencode(json_encode($_POST)) ?>"
                alt="Graphique de la vitesse du vent"
            />
        </span>
        <span>
            <img
            src="generate.php?type=rain&data=<?= urlencode(json_encode($_POST)) ?>"
            alt="Graphique de la quantité de pluie tombée"
            />
        </span>
        <span>
            <img
                src="generate.php?type=wind&data=<?= urlencode(json_encode($_POST)) ?>"
                alt="Graphique de la vitesse du vent"
            />
        </span>
        <div class="break_flex"></div>
        <table>
            <thead>
                <tr>
                    <td colspan="4">Liste des relevés</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>Température</td>
                    <td>Pluie</td>
                    <td>Vent</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($all as $key => $value) {
                ?>
                <tr>
                    <td><?= $all[$key][3] ?></td>
                    <td><?= $all[$key][0] ?></td>
                    <td><?= $all[$key][1] ?></td>
                    <td><?= $all[$key][2] ?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        <div class="break_flex"></div>
        <table>
            <thead>
                <tr>
                    <td colspan="5">Statistiques</td>
                </tr>
                <tr>
                    <td>X</td>
                    <td>Température</td>
                    <td>Pluie</td>
                    <td>Vent</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Max</td>
                    <td><?= max($_POST['temp']) ?></td>
                    <td><?= max($_POST['rain']) ?></td>
                    <td><?= max($_POST['wind']) ?></td>
                </tr>
                <tr>
                    <td>Min</td>
                    <td><?= min($_POST['temp']) ?></td>
                    <td><?= min($_POST['rain']) ?></td>
                    <td><?= min($_POST['wind']) ?></td>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>

<!---
Code écrit pas https://github.com/QuentinBubu/
Pour https://made.alwaysdata.net
Voir vos droits https://github.com/QuentinBubu/made/tree/master/stats
--->