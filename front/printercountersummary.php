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
|___________________________________Version 1.0.0 by Snayto (Arnaud WIEREL) @2023________________________________________|
*/

echo'<!DOCTYPE html>';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
include_once ('../../../inc/includes.php');

Html::header(__('Printer Counter Summary', 'printercountersummary'), $_SERVER['PHP_SELF'], "tools", "PluginPrinterCounterSummary", "menu");

echo '<div class="center">';
echo '<h2>'.__('Welcome to the Printer Counter Summary plugin!', 'printercountersummary').'</h2>';
echo '<link rel="stylesheet" type="text/css" href="printercountersummary.css">';

include_once ("../inc/Nom.class.php");
include_once ("../inc/IPAdress.class.php");
include_once ("../inc/Date.class.php");
include_once ("../inc/CompteurTot.class.php");
include_once ("../inc/Total.class.php");

$nom = new Nom($pdo);
$ipAdress = new IPAdress($pdo);
$values = $nom->getValues();
$itemsId = $nom->getItemsId();
$ipValues = $ipAdress->getValues();

$compteurTot = new CompteurTot($pdo);
$compteurs = $compteurTot->getCompteurs();

echo '<table class="styled-table">';
echo '<thead>';
echo '<tr>';
echo '<th>' . $nom->getName() . '</th>';
echo '<th>Adresse IP</th>'; 
echo '<th>Dernière date de relevé</th>';
echo '<th>Compteurs</th>';
echo '<th>Totaux</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($values as $value) {
    $imprimanteId = $value['id'];
    $imprimanteItemId = $value['items_id'];
    echo '<tr>';
    echo '<td>' . $value['value'] . '</td>';

    $ipAddress = $ipAdress->getIPByPrinterId($imprimanteItemId);
    echo '<td>' . $ipAddress . '</td>';

    $date = new Date($pdo);
    $lastDate = $date->getLastDate($value['id']);
    if ($lastDate) {
        echo '<td>' . $lastDate . '</td>';
    } else {
        echo '<td>No Date found</td>';
    }

    if (isset($compteurs[$value['id']])) {
        echo '<td>';
        $total = 0;
        foreach ($compteurs[$value['id']]['values'] as $index => $counter) {
            echo $compteurs[$value['id']]['names'][$index] . ': ' . $counter . '<br>';
            $total += $counter;
        }
        echo '</td>';
        echo '<td>' . $total . '</td>';
    } else {
        echo '<td colspan="2">No Counters found</td>';
    }

    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

/*echo '
<script>
    $(document).ready(function(){
        $("#saveDataButton").on("click", function() {
            $.ajax({
                url: "../PHP/executeSaveData.php",
                type: "POST",
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>';
echo '<button id="saveDataButton">Save Data</button>';*/
echo '</div>';

Html::footer();
?>
