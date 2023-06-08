<?php
include ("Connect_BDD.php"); // Assurez-vous que ce chemin d'accès est correct

function executeQuery($pdo) {
    $sql = "
        SELECT add_data.value as Nom, rec.date, GROUP_CONCAT(counters.value) as Compteurs
        FROM glpi_plugin_printercounters_records rec
        JOIN glpi_plugin_printercounters_additionals_datas add_data 
          ON rec.plugin_printercounters_items_recordmodels_id = add_data.plugin_printercounters_items_recordmodels_id
             AND add_data.name = 'Nom'
        JOIN glpi_plugin_printercounters_counters counters 
          ON rec.id = counters.plugin_printercounters_records_id
        WHERE rec.date = (
            SELECT MAX(rec2.date)
            FROM glpi_plugin_printercounters_records rec2
            WHERE rec2.plugin_printercounters_items_recordmodels_id = rec.plugin_printercounters_items_recordmodels_id
          )
        GROUP BY rec.plugin_printercounters_items_recordmodels_id;
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $rows = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }
    
    return $rows;
}

$result = executeQuery($pdo);
?>
