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
include("../PHP/Connect_BDD.php");

class IPAdress
{
    private $ip;
    private $values;
    private $id;

    public function __construct($pdo)
    {
        $sql = "
            SELECT glpi_printers.id AS id, glpi_ipaddresses.name AS ip
            FROM glpi_printers
            LEFT JOIN glpi_networkports ON (glpi_networkports.items_id = glpi_printers.id AND glpi_networkports.itemtype = 'Printer')
            LEFT JOIN glpi_networknames ON glpi_networknames.items_id = glpi_networkports.id
            LEFT JOIN glpi_ipaddresses ON glpi_ipaddresses.items_id = glpi_networknames.id AND glpi_ipaddresses.itemtype = 'NetworkName'
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
            // Transforme les résultats en un tableau associatif avec les IDs des imprimantes comme clés et les adresses IP comme valeurs
            foreach ($rows as $row) {
                $this->values[$row['id']] = $row['ip'];
            }
        }
    }

    public function getIPByPrinterId($printerId)
    {
        if (isset($this->values[$printerId])) {
            return $this->values[$printerId];
        } else {
            return 'No IP Address found';
        }
    }


    public function getIP()
    {
        return $this->ip;
    }

    public function getValues()
    {
        $values = [];
        if (is_array($this->values) || is_object($this->values)) {
            foreach ($this->values as $row) {
                if (is_array($row) || is_object($row)) {
                    if (isset($row['id']) && isset($row['ip'])) {
                        $values[$row['id']] = $row['ip'];
                    }
                }
            }
        }
        return $values;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIP($ip)
    {
        $this->ip = $ip;
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