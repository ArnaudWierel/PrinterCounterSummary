<?php

// Assurez-vous que ce chemin d'accès est correct
include ("../PHP/Connect_BDD.php");

interface NomInterface {
    public function __construct($pdo);
    public function getName();
    public function getValue();
    public function getId();
    public function setName($name);
    public function setValue($value);
    public function setId($id);
}

class Nom implements NomInterface {
    private $name;
    private $value;
    private $id;

    public function __construct($pdo) {
        $sql = "
            SELECT `name`, `value`, `plugin_printercounters_items_recordmodels_id` AS `id`
            FROM `glpi_plugin_printercounters_additionals_datas`
            WHERE `name` = 'Nom'
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->name = $row['name'];
            $this->value = $row['value'];
            $this->id = $row['id'];
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
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