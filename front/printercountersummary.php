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

// glpi page for the plugin
// Path: front\printercountersummary.php
echo'<!DOCTYPE html>';
echo '
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
include_once ('../../../inc/includes.php');

// include the header of the page
Html::header(__('Printer Counter Summary', 'printercountersummary'), $_SERVER['PHP_SELF'], "tools", "PluginPrinterCounterSummary", "menu");

// include a title for the page in order to test the plugin
echo '<div class="center">';
echo '<h2>'.__('Welcome to the Printer Counter Summary plugin!', 'printercountersummary').'</h2>';

// Include the CSS file
echo '<link rel="stylesheet" type="text/css" href="printercountersummary.css">';

// Make sure this path is correct
include_once ("../inc/Nom.class.php");
include_once ("../inc/IPAdress.class.php");
include_once ("../inc/Date.class.php");
include_once ("../inc/CompteurTot.class.php");
include_once ("../inc/Total.class.php");
include_once ("../PHP/save_data.php");

// Fetching the values of Nom
$nom = new Nom($pdo);
$ipAdress = new IPAdress($pdo);
$values = $nom->getValues();
$valuesIP = $ipAdress->getValues();

// Fetching the last counters
$compteurTot = new CompteurTot($pdo);
$compteurs = $compteurTot->getCompteurs();

// Displaying the values in a table
echo '<table class="styled-table">';
echo '<thead>';
echo '<tr>';
echo '<th>' . $nom->getName() . '</th>';
echo '<th>Adresse IP</th>'; // Add new column for IP Adress
echo '<th>Dernière date de relevé</th>';
echo '<th>Compteurs</th>';
echo '<th>Totaux</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($values as $value) {
    $imprimanteId = $value['id'];
    echo '<tr>';
    echo '<td>' . $value['value'] . '</td>';

    // Display IP Adress
// Displaying the IP addresses
foreach ($valuesIP as $value) {
    echo $value['id'] . ': ' . $value['ip'] . '<br>';
}

    // Perform additional queries with $value
    $date = new Date($pdo);
    $lastDate = $date->getLastDate($value['id']);
    if ($lastDate) {
        echo '<td>' . $lastDate . '</td>';
    } else {
        echo '<td>No Date found</td>';
    }

     if ($lastDate) {
        $derniereDate = "'" . $lastDate . "'";
    } else {
        $derniereDate = "null";
    }

    if (isset($compteurs[$value['id']])) {
        echo '<td>';
        $total = 0; // Variable pour calculer le total
        foreach ($compteurs[$value['id']]['values'] as $index => $counter) {
            echo $compteurs[$value['id']]['names'][$index] . ': ' . $counter . '<br>'; // Affichage du nom et de la valeur du compteur
            $total += $counter; // Ajout de la valeur au total
        }
        echo '</td>';
        echo '<td>' . $total . '</td>'; // Affichage du total
    } else {
        echo '<td colspan="2">No Counters found</td>';
    }

    echo '</tr>';

}

echo '</tbody>';
echo '</table>';
// quand on clique sur le bouton "Enregistrer" on initalise la fonction save_data
echo '
<script>
    $(document).ready(function(){
        $("#saveDataButton").on("click", function() {
            $.ajax({
                url: "../PHP/executeSaveData.php", // Remplacez par le chemin de votre script PHP
                type: "POST",
                success: function(response) {
                    // Ici, vous pouvez gérer la réponse du serveur
                    console.log(response);
                },
                error: function(error) {
                    // Ici, vous pouvez gérer les erreurs
                    console.log(error);
                }
            });
        });
    });
</script>';
echo '<button id="saveDataButton">Save Data</button>';
echo '</div>';

// include the footer of the page
Html::footer();
?>