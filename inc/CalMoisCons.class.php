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

// class qui a pour fonction de lire la table "votre_table" et de faire le calcul des compteurs par imprimante et par mois

class CalMoisCons
{
    private $id_relevé;
    private $imprimante_id;
    private $compteur_name;
    private $compteur;
    private $id_relevé_1;
    private $pdo;
    private $id_relevé_2;
    private $imprimante_id_2;
    private $imprimante_name_2;
    private $compteur_name_2;
    private $compteur_2;
    private $table = 'ZDisplayPrintersCountersSummary';

    public function __construct()
    {
        include '../PHP/Connect_BDD.php';
        $this->pdo = $pdo;
    }

    public function main()
    {
        // on cree la table ZDisplayPrintersCountersSummary
        $this->CreateNewTable($this->table);

        $query = "SELECT id_relevé, imprimante_id, imprimante_name, compteur_name, compteur FROM votre_table WHERE id_relevé = (SELECT MAX(id_relevé) FROM votre_table)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        // on récupère les données dans un tableau associatif
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $this->id_relevé_1 = $row['id_relevé'];
            echo $row['imprimante_name'] . $row['compteur_name'] . $row['compteur'] . "<br>";
        }

        // puis on lui enlève 1
        $this->id_relevé_1 = $this->id_relevé_1 - 1;

        // on ajoute la nouvelle colonne où on stockera les données
        $nom_colonne = $this->addNewColumn();

        // ...
        foreach ($rows as $row) {
            // on récupère les données l'id_relvé de rows
            $this->id_relevé = $row['id_relevé'];
            $this->imprimante_id = $row['imprimante_id'];
            $this->compteur_name = $row['compteur_name'];
            $this->compteur = $row['compteur'];

            // on récupère la ligne correspondante mais avec l'id_relevé - 1
            $query = "SELECT id_relevé, imprimante_id, imprimante_name, compteur_name, compteur FROM votre_table WHERE id_relevé = :id_releve AND imprimante_id = :imprimante_id AND compteur_name = :compteur_name";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id_releve', $this->id_relevé_1, PDO::PARAM_INT);
            $stmt->bindParam(':imprimante_id', $this->imprimante_id, PDO::PARAM_INT);
            $stmt->bindParam(':compteur_name', $this->compteur_name, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                // on récupère les données dans un tableau associatif avec des noms différents
                $rows_2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->id_relevé_2 = $rows_2[0]['id_relevé'];
                $this->imprimante_id_2 = $rows_2[0]['imprimante_id'];
                $this->imprimante_name_2 = $rows_2[0]['imprimante_name'];
                $this->compteur_name_2 = $rows_2[0]['compteur_name'];
                $this->compteur_2 = $rows_2[0]['compteur'];
                $résultat = $this->calcul($this->compteur, $this->compteur_2);
            }
            // on insère imprimante_id, imprimante_name, compteur_name, résultat dans la table ZDisplayPrintersCountersSummary
            // on vérifie si l'impriante_id, le compteur_name n'existe pas déjà dans la table ZDisplayPrintersCountersSummary sinon on met à jour la ligne
            $query = "SELECT id_imprimante, nom_imprimante, nom_compteur FROM ZDisplayPrintersCountersSummary WHERE id_imprimante = :imprimante_id AND nom_compteur = :compteur_name";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':imprimante_id', $this->imprimante_id, PDO::PARAM_INT);
            $stmt->bindParam(':compteur_name', $this->compteur_name, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                // on met à jour la ligne
                $query = "UPDATE ZDisplayPrintersCountersSummary SET `$nom_colonne` = :resultat WHERE id_imprimante = :imprimante_id AND nom_compteur = :compteur_name";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':imprimante_id', $this->imprimante_id, PDO::PARAM_INT);
                $stmt->bindParam(':compteur_name', $this->compteur_name, PDO::PARAM_STR);
                $stmt->bindParam(':resultat', $résultat, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                // on insère la ligne
                $query = "INSERT INTO ZDisplayPrintersCountersSummary (id_imprimante, nom_imprimante, nom_compteur, `$nom_colonne`) VALUES (:imprimante_id, :imprimante_name, :compteur_name, :resultat)";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':imprimante_id', $this->imprimante_id, PDO::PARAM_INT);
                $stmt->bindParam(':imprimante_name', $this->imprimante_name_2, PDO::PARAM_STR);
                $stmt->bindParam(':compteur_name', $this->compteur_name, PDO::PARAM_STR);
                $stmt->bindParam(':resultat', $résultat, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        echo "Data saved successfully.";
    }

    private function CreateNewTable($table)
    {
        // Vérification si la table existe
        $sql = "SHOW TABLES LIKE '$table'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) == 0) {
            // Création de la table
            $sql = "CREATE TABLE IF NOT EXISTS `$table` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_imprimante` INT UNSIGNED NOT NULL,
                `nom_imprimante` VARCHAR(255) NOT NULL,
                `nom_compteur` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $this->pdo->exec($sql);
        }
    }

    private function columnExists($column)
    {
        $stmt = $this->pdo->query("SHOW COLUMNS FROM `{$this->table}` LIKE '$column'");
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    private function addNewColumn()
    {
        // Obtenir toutes les colonnes de la table
        $stmt = $this->pdo->query("SHOW COLUMNS FROM `{$this->table}`");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Supprimer la première colonne 'id_imprimante'
        array_shift($columns);
        // Supprimer la deuxième colonne 'nom_imprimante'
        array_shift($columns);
        // Supprimer la troisième colonne 'nom_compteur'
        array_shift($columns);

        // Trier les colonnes par ordre alphabétique des noms
        sort($columns);

        if (!$this->columnExists('07/2023')) {
            $query = "ALTER TABLE `{$this->table}` ADD COLUMN `07/2023` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `nom_compteur`";
            $this->pdo->exec($query);
            $newColumnName = '07/2023';
        } else {
            $youngestColumn = "01/2000"; // some default very old date
            foreach ($columns as $column) {
                if (DateTime::createFromFormat('m/Y', $column) > DateTime::createFromFormat('m/Y', $youngestColumn)) {
                    $youngestColumn = $column;
                }
            }
            // Extraire le mois et l'année de la colonne la plus jeune
            list($month, $year) = explode('/', $youngestColumn);

            // Calculer le mois et l'année suivants
            $nextMonth = (int) $month + 1;
            $nextYear = (int) $year;
            if ($nextMonth > 12) {
                $nextMonth = 1;
                $nextYear++;
            }

            // Formatage du nouveau nom de colonne
            $newColumnName = sprintf('%02d/%04d', $nextMonth, $nextYear);

            // Ajouter la nouvelle colonne si elle n'existe pas déjà
            if (!$this->columnExists($newColumnName)) {
                $query = "ALTER TABLE `{$this->table}` ADD COLUMN `$newColumnName` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `$youngestColumn`";
                $this->pdo->exec($query);
            }
        }


        return $newColumnName;
    }

    private function calcul($compteur, $compteur_2)
    {
        // on fait le calcul
        $calcul = $compteur - $compteur_2;
        if ($calcul < 0) {
            $calcul = 0;
        }
        // retourne le résultat
        return $calcul;
    }
}

$calMoisCons = new CalMoisCons();
$calMoisCons->main();