<?php

// Assurez-vous que ce chemin d'accès est correct
include ("../PHP/Connect_BDD.php");

interface NomInterface {
    public function __construct($pdo);
    public function getName();
    public function getValues();
    public function getId();
    public function setName($name);
    public function setValue($value);
    public function setId($id);
}

class Nom implements NomInterface {
    private $name;
    private $values;
    private $id;

    public function __construct($pdo) {
        $sql = "
            SELECT `name`, `value`, `plugin_printercounters_items_recordmodels_id` AS `id`
            FROM `glpi_plugin_printercounters_additionals_datas`
            WHERE `name` = 'Nom'
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
            $this->name = $rows[0]['name'];
            $this->values = $rows;
            $this->id = $rows[0]['id'];
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getValues() {
        return $this->values;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function setId($id) {
        $this->id = $id;
    }
}