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
interface NomInterface
{
    public function __construct($pdo);
    public function getName();
    public function getValues();
    public function getId();
    public function getItemsId(); // Nouvelle méthode pour récupérer items_id
    public function setName($name);
    public function setValue($value);
    public function setId($id);
}

class Nom implements NomInterface
{
    private $name;
    private $values;
    private $id;
    private $itemsId; // Nouvelle propriété pour stocker items_id

    public function __construct($pdo)
    {
        $sql = "
            SELECT additionals.`name`, additionals.`value`, additionals.`plugin_printercounters_items_recordmodels_id` AS `id`, recordmodels.`items_id`
            FROM `glpi_plugin_printercounters_additionals_datas` AS additionals
            LEFT JOIN `glpi_plugin_printercounters_items_recordmodels` AS recordmodels ON additionals.`plugin_printercounters_items_recordmodels_id` = recordmodels.`id`
            WHERE additionals.`name` = 'Nom'
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
            $this->name = $rows[0]['name'];
            $this->values = $rows;
            $this->id = $rows[0]['id'];
            $this->itemsId = $rows[0]['items_id']; // Stocke items_id
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getItemsId()
    {
        return $this->itemsId; // Retourne items_id
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}