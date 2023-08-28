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
class DataSaver
{

    private $pdo;

    public function __construct()
    {
        include("../PHP/Connect_BDD.php");
        $this->pdo = $pdo;
    }

    // Méthode pour enregistrer les données automatiquement
    public function saveData()
    {
        // Include the required files
        include_once('../../../inc/includes.php');
        include_once("../inc/Nom.class.php");
        include_once("../inc/Date.class.php");
        include_once("../inc/CompteurTot.class.php");
        include_once("../inc/Total.class.php");

        // Fetch the values of Nom
        $nom = new Nom($this->pdo);
        $values = $nom->getValues();

        // Fetch the last counters
        $compteurTot = new CompteurTot($this->pdo);
        $compteurs = $compteurTot->getCompteurs();

        // Get the maximum id_relevé in the table
        $stmt = $this->pdo->query("SELECT MAX(id_relevé) AS maxId FROM votre_table");
        $row = $stmt->fetch();
        $maxId = $row['maxId'];

        // Loop through the values and save the data into the appropriate table
        foreach ($values as $value) {
            $imprimanteId = $value['id'];
            $imprimanteName = $value['value']; // Fetch the printer's name

            // Get the last date of reading
            $date = new Date($this->pdo);
            $lastDate = $date->getLastDate($value['id']);

            // Fetch the counters
            if (isset($compteurs[$value['id']])) {
                $counters = $compteurs[$value['id']]['values'];
                $counterNames = $compteurs[$value['id']]['names'];
            } else {
                $counters = [];
                $counterNames = [];
            }

            // Save each counter individually
            for ($i = 0; $i < count($counters); $i++) {
                // Insert the data into the table 'votre_table'
                $insertQuery = "INSERT INTO votre_table (id_relevé, imprimante_id, imprimante_name, date, compteur_name, compteur, total) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($insertQuery);
                $stmt->execute([$maxId + 1, $imprimanteId, $imprimanteName, $lastDate, $counterNames[$i], $counters[$i], array_sum($counters)]);
            }

        }
        // Increment maxId after the loop for a series of printers
        $maxId++;
    }
}

$dataSaver = new DataSaver();
$dataSaver->saveData();

?>