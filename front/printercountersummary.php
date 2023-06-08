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
include ("../PHP/test.php");  // Assurez-vous que ce chemin d'accès est correct

// include a title for the page in order to test the plugin
echo '<div class="center">';
echo '<h2>'.__('Welcome to the Printer Counter Summary plugin!', 'printercountersummary').'</h2>';

/// Pour afficher les résultats sous forme de tableau
echo "<table>";
// Header pour le nom
echo "<tr>";
echo "<th>" . $result[0]['name'] . "</th>";
echo "</tr>";

// Lignes pour chaque valeur
foreach($result as $row) {
    echo "<tr>";
    echo "<td>" . $row['value'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo '</div>';

// include the footer of the page
Html::footer();
?>
