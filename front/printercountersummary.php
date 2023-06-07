<?php

include ("../../../inc/includes.php");
include ("Test.php");  // Assurez-vous que ce chemin d'accès est correct

Html::header(
    __("Printer Counter Summary", "printercountersummary"), 
    $_SERVER['PHP_SELF'], 
    "plugins", 
    "printercountersummary", 
    "printercountersummary"
);

echo '<div class="center">';
echo '<h2>' . __('Welcome to the Printer Counter Summary plugin!', 'printercountersummary') . '</h2>';

// Affichage des noms des tables
foreach($tables as $table) {
    echo $table, '<br>';
}

echo '</div>';

Html::footer();
?>
