<?php
$temp = $_POST['temp'];
$rain = $_POST['rain'];
$wind = $_POST['wind'];
$date = $_POST['date'];
$hour = $_POST['hour'];
$all = [];
for ($i = 0; $i < count($temp); $i++) {
    //On mets dans all les informations tout en créant un tableau
    $all[$i] = [$temp[$i], $rain[$i], $wind[$i], date($date[$i] . ' ' . $hour[$i])];
}
$columns = array_column($all, 3); //Séléction des lignes date
array_multisort($columns, SORT_DESC, $all); // Mise dans l'ordre croissant des tableaux
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/base.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
    <title>Graphiques</title>
</head>
<body>
<section id="graphs">
        <img src="generate.php?type=temp&data=<?= urlencode(json_encode($_POST)) ?>" >
        <img src="generate.php?type=wind&data=<?= urlencode(json_encode($_POST)) ?>" >
        <img src="generate.php?type=rain&data=<?= urlencode(json_encode($_POST)) ?>" >
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
</section>
</body>
</html>