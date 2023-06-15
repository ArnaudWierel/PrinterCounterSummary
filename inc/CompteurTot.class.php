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

class CompteurTot {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getCompteurs() {
        $sql = "
            SELECT r.`plugin_printercounters_items_recordmodels_id` AS id, r.`date`, c.`value`, ct.`name`
            FROM `glpi_plugin_printercounters_records` r
            INNER JOIN `glpi_plugin_printercounters_counters` c
                ON r.`id` = c.`plugin_printercounters_records_id`
            INNER JOIN `glpi_plugin_printercounters_countertypes_recordmodels` ctrm
                ON c.`plugin_printercounters_countertypes_recordmodels_id` = ctrm.`id`
            INNER JOIN `glpi_plugin_printercounters_countertypes` ct
                ON ctrm.`plugin_printercounters_countertypes_id` = ct.`id`
            WHERE r.`date` = (
                SELECT MAX(`date`)
                FROM `glpi_plugin_printercounters_records`
                WHERE `plugin_printercounters_items_recordmodels_id` = r.`plugin_printercounters_items_recordmodels_id`
            )
            ORDER BY r.`plugin_printercounters_items_recordmodels_id`
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $compteurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            if (!isset($compteurs[$id])) {
                $compteurs[$id] = [
                    'date' => $row['date'],
                    'values' => [$row['value']],
                    'names' => [$row['name']],
                ];
            } else {
                $compteurs[$id]['values'][] = $row['value'];
                $compteurs[$id]['names'][] = $row['name'];
            }
        }
        
        return $compteurs;
    }
}
