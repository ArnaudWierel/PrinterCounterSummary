<?php
/*
__________________________________________________________________________________________________________________________
| ______     _       _            _____                   _            _____                                             |
| | ___ \   (_)     | |          /  __ \                 | |          /  ___|                                            |
| | |_/ / __ _ _ __ | |_ ___ _ __| /  \/ ___  _   _ _ __ | |_ ___ _ __\ `--. _   _ _ __ ___  _ __ ___   __ _ _ __ _   _  |
| |  __/ '__| | '_ \| __/ _ \ '__| |    / _ \| | | | '_ \| __/ _ \ '__|`--. \ | | | '_ ` _ \| '_ ` _ \ / _` | '__| | | | |
| | |  | |  | | | | | ||  __/ |  | \__/\ (_) | |_| | | | | ||  __/ |  /\__/ / |_| | | | | | | | | | | | (_| | |  | |_| | |
| \_|  |_|  |_|_| |_|\__\___|_|   \____/\___/ \__,_|_| |_|\__\___|_|  \____/ \__,_|_| |_| |_|_| |_| |_|\__,_|_|   \__, | |
|                                                                                                                  __/ | |
|                                                                                                                 |___/  |
|___________________________________Version 2.0.0 by Snayto (Arnaud WIEREL) @2023________________________________________|
*/

echo '<!DOCTYPE html>';

include_once('../../../inc/includes.php');
include_once("../inc/ShowMonthCons.class.php");
include_once("../inc/Nom.class.php");

Html::header(__('Printer Counter Summary', 'printercountersummary'), $_SERVER['PHP_SELF'], "tools", "PluginPrinterCounterSummary", "menu");
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>';
echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />';
echo '<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="showmonthcons.css">';

$id = $_GET['id'];
$itemsId = $_GET['itemid'];
$nom = new Nom($pdo);
$info = new ShowMonthCons($pdo);
$info->getID($id);

$rows = $info->info();

// pas la première et deuxième colonne

echo '<div class="center futuristic-container">'; // Ajoutez une classe de conteneur
echo '<h2>' . $nom->getNames($pdo, $itemsId) . '</h2>';

echo '<table id="example" class="styled-table" style="width:100%">';
if (!empty($rows)) {
    $firstRow = $rows[0];
    echo '<thead>';
    echo '<tr>';
    echo '<th>Nom du compteur</th>';
    foreach ($firstRow as $key => $value) {
        // on saute une colonne du nom de nom_compteur et on affiche 'Nom du compteur'
        if ($key == 'nom_compteur') {
            continue;
        }
        echo '<th>' . htmlspecialchars($key) . '</th>';
    }
}
echo '<tbody>';
//affiche les lignes
foreach ($rows as $row) {
    echo '<tr>';
    foreach ($row as $key => $value) {
        echo '<td>' . htmlspecialchars($value) . '</td>';
    }
}
echo '</table>';
echo '<br>';

// on fait un autre tableau dans lequel on affiche les compteurs et les totaux par colonne (mois)
echo '<h2 class="titre_total">Totaux par mois</h2>';
echo '<table id="example2" class="styled-table" style="width:100%">';
echo '<thead>';
echo '<tr>';
foreach ($firstRow as $key => $value) {
    // on saute une colonne du nom de nom_compteur et on affiche 'Nom du compteur'
    if ($key == 'nom_compteur') {
        continue;
    }
    echo '<th>' . htmlspecialchars($key) . '</th>';
}
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Initialisez le tableau de totaux par colonne
$columnTotals = array_fill_keys(array_keys($firstRow), 0);

foreach ($rows as $row) {
    foreach ($row as $key => $value) {
        if ($key == 'nom_compteur') {
            continue;
        }
        // Accumulez les totaux par colonne
        $columnTotals[$key] += $value;
    }
}

// Affichez les totaux par colonne
echo '<tr>';
foreach ($columnTotals as $key => $total) {
    // on saute la première colonne du nom de nom_compteur
    if ($key == 'nom_compteur') {
        continue;
    }
    echo '<td>' . $total . '</td>';
}
echo '</tr>';
echo '</tbody>';
echo '</table>';

echo '<script>';
echo '$(document).ready(function() {';
echo '$("#example").DataTable();';
echo '$("#example2").DataTable();';
echo '});';
echo '</script>';
echo '</div>';
Html::footer();

?>