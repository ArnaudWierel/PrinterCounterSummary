<?php
include ('../../../inc/includes.php');

// Vérifier si l'utilisateur est connecté et a les autorisations nécessaires
Session::checkRight("plugin_printercountersummary", READ);

// Afficher l'en-tête
if (Session::getCurrentInterface() == 'central') {
    Html::header(PluginPrintercountersummaryMenu::getTypeName(2), '', "tools", "pluginprintercountersummarymenu", "report");
} else {
    Html::helpHeader(PluginPrintercountersummaryMenu::getTypeName(2));
}

// Afficher le menu
$menu = new PluginPrintercountersummaryMenu();
$menu->showMenu();

// Ici, vous pouvez ajouter le code pour récupérer les données des imprimantes et les afficher.
// Cela dépendra de la façon dont vous stockez et récupérez ces données.
// Vous pourriez utiliser une classe existante de GLPI ou du plugin PrinterCounters, ou créer votre propre classe.
// Par exemple, vous pourriez avoir quelque chose comme ceci :
// $printerReport = new PrinterReport();
// $printerReport->showReport();

// Afficher le pied de page
if (Session::getCurrentInterface() == 'central') {
    Html::footer();
} else {
    Html::helpFooter();
}
?>
