<?php

// Assurez-vous que ce chemin d'accès est correct
include ("../PHP/Connect_BDD.php");

interface DateInterface {
    public function __construct($pdo);
    public function getLastDate($id);
    public function setDate($date);
    public function getDate();
}

class Date implements DateInterface {
    private $pdo;
    private $date;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getLastDate($id) {
        $sql = "
            SELECT `date`
            FROM `glpi_plugin_printercounters_records`
            WHERE `plugin_printercounters_items_recordmodels_id` = :id
            ORDER BY `date` DESC
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->date = $row['date'];
            return $this->date;
        }

        return null;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }
}
