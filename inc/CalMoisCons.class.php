<?php
// class qui a pour fonction de lire la table "votre_table" et de faire le calcul des compteurs par imprimante et par mois
require_once '../PHP/Connect_BDD.php';
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

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function main()
    {
        $query = "SELECT id_relevé, imprimante_id, imprimante_name, compteur_name, compteur FROM votre_table WHERE id_relevé = (SELECT MAX(id_relevé) FROM votre_table)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        // on récupère les données dans un tableau associatif
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // on récupère l'id_relevé - 1
        $this->id_relevé_1 = $rows['id_relevé'] - 1;

        // on ajoute la nouvelle colonne où on stockera les données
        $nom_colonne = $this->addNewColumn();

        foreach ($rows as $row) {
            // on récupere les données l'id_relvé de rows
            $this->id_relevé = $row['id_relevé'];
            $this->imprimante_id = $row['imprimante_id'];
            $this->compteur_name = $row['compteur_name'];
            $this->compteur = $row['compteur'];

            // on récupère la ligne correspondante mais avec l'id_relevé - 1
            $query = "SELECT id_relevé, imprimante_id, imprimante_name, compteur_name, compteur FROM votre_table WHERE id_relevé = {$this->id_relevé_1} AND imprimante_id = {$this->imprimante_id} AND compteur_name = {$this->compteur_name}";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                // on récupère les données dans un tableau associatif avecx des nom différent
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->id_relevé_2 = $rows['id_relevé'];
                $this->imprimante_id_2 = $rows['imprimante_id'];
                $this->imprimante_name_2 = $rows['imprimante_name'];
                $this->compteur_name_2 = $rows['compteur_name'];
                $this->compteur_2 = $rows['compteur'];
                $résultat = $this->calcul($this->compteur, $this->compteur_2);
            }
            // on insère imprimante_id, imprimante_name, compteur_name, résultat dans la table ZDisplayPrintersCountersSummary
            $query = "INSERT INTO ZDisplayPrintersCountersSummary (imprimante_id, imprimante_name, compteur_name, $nom_colonne) VALUES ({$this->imprimante_id}, {$this->imprimante_name_2}, {$this->compteur_name}, {$résultat})";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
        }
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
                `id_imprimante` INT UNSIGNED NOT NULL AUTO_INCREMENT,
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
        $calcul = $compteur_2 - $compteur;
        // retourne le résultat
        return $calcul;
    }
}