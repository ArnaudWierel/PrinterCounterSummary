<?php
include_once "../inc/Nom.class.php";
include_once "../inc/CompteurMois.class.php";
include_once "../PHP/Connect_BDD.php";

// Dans form.php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Assurez-vous que l'ID est un nombre entier pour éviter les injections SQL
    echo '<!DOCTYPE html>';

    include_once('../../../inc/includes.php');

    Html::header(__('Printer Counter Summary', 'printercountersummary'), $_SERVER['PHP_SELF'], "tools", "PluginPrinterCounterSummary", "menu");
    echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>';
    echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />';
    echo '<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>';

    $nom = new Nom($pdo);
    $NomParId = $nom->GetNameByid($id, $pdo);

    // Créez une nouvelle instance de la classe CompteurMois
    $compteurMois = new CompteurMois($pdo);

    // Récupérez le compteur pour l'ID spécifique
    $compteurs = $compteurMois->getMonthlyCounters($id);

    // Récupérez les mois distincts à partir des clés du tableau $compteurs
    $months = array_keys($compteurs);
    $monthsFormatted = [];

    // Formatage des mois au format MM-YYYY
    foreach ($months as $month) {
        // affichez le mois précédent au format MM-YYYY
        $monthFormatted = date('M-Y', strtotime($month));
        $monthsFormatted[] = $monthFormatted;
    }

    // affichage du nom de l'imprimante et des compteurs
    echo '<table class="styled-table" id="myTable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Nom</th>';

    // Affichez les noms de mois correspondant aux colonnes
    foreach ($monthsFormatted as $month) {
        echo '<th>' . $month . '</th>';
    }

    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    echo '<tr>';
    echo '<td>' . $NomParId . '</td>';

    // Parcourez les mois et affichez les valeurs correspondantes
    foreach ($months as $month) {
        echo '<td>' . $compteurs[$month] . '</td>';
    }

    echo '</tr>';

    echo '</tbody>';
    echo '</table>';

    echo '<script>';
    echo '$(document).ready(function() {';
    echo '$("#myTable").DataTable();';
    echo '});';
    echo '</script>';
    Html::footer();
} else {
    echo '<!DOCTYPE html>';

    include_once('../../../inc/includes.php');

    Html::header(__('Printer Counter Summary', 'printercountersummary'), $_SERVER['PHP_SELF'], "tools", "PluginPrinterCounterSummary", "menu");
    echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>';
    echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />';
    echo '<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>';

    echo '<h2> Aucun id n\'a été transmis </h2>';

    Html::footer();
}