<?php

// Assurez-vous que ce chemin d'accès est correct
include ("../PHP/Connect_BDD.php");

class IPAdress {
    private $ip;
    private $values;
    private $id;

    public function __construct($pdo) {
        $sql = "
            SELECT glpi_printers.id AS id, glpi_ipaddresses.name AS ip
            FROM glpi_printers
            JOIN glpi_networkports ON glpi_networkports.items_id = glpi_printers.id 
            AND glpi_networkports.itemtype = 'Printer'
            JOIN glpi_networknames ON glpi_networknames.id = glpi_networkports.networknames_id
            JOIN glpi_ipaddresses ON glpi_ipaddresses.items_id = glpi_networknames.id
            AND glpi_ipaddresses.itemtype = 'NetworkName'
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
            $this->ip = $rows[0]['ip'];
            $this->values = $rows;
            $this->id = $rows[0]['id'];
        }
    }

    public function getIP() {
        return $this->ip;
    }

    public function getValues() {
        return $this->values;
    }

    public function getId() {
        return $this->id;
    }

    public function setIP($ip) {
        $this->ip = $ip;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setId($id) {
        $this->id = $id;
    }
}
