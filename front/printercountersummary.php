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
include ('../../../inc/includes.php');

// include the header of the page
Html::header(__('Printer Counter Summary', 'printercountersummary'), $_SERVER['PHP_SELF'], "tools", "PluginPrinterCounterSummary", "menu");

// Make sure this path is correct
include ("../inc/Nom.class.php");
include ("../inc/Date.class.php");

// include a title for the page in order to test the plugin
echo '<div class="center">';
echo '<h2>'.__('Welcome to the Printer Counter Summary plugin!', 'printercountersummary').'</h2>';

// Include the CSS file
echo '<link rel="stylesheet" type="text/css" href="printercountersummary.css">';

// Fetching the values of Nom
$nom = new Nom($pdo);
$values = $nom->getValues();

// Displaying the values in a table
echo '<table class="styled-table">';
echo '<thead>';
echo '<tr>';
echo '<th>' . $nom->getName() . '</th>';
echo '<th>Last Date</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($values as $value) {
    echo '<tr>';
    echo '<td>' . $value['value'] . '</td>';

    // Perform additional queries with $value
    $date = new Date($pdo);
    $lastDate = $date->getLastDate($value['id']);
    if ($lastDate) {
        echo '<td>' . $lastDate . '</td>';
    } else {
        echo '<td>No Date found</td>';
    }
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

echo '</div>';

// include the footer of the page
Html::footer();

?>
