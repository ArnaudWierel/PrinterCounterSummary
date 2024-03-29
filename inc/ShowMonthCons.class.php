<?php
include '../PHP/Connect_BDD.php';

class ShowMonthCons
{
    private $pdo;
    private $id;
    private $Nom_Imprimante;
    private $Nom_Compteur;
    private $Compteur;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function info()
    {
        $query = "SELECT * FROM ZDisplayPrintersCountersSummary WHERE id_imprimante = :id_imprimante";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_imprimante', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        // formate les données en tableau associatif
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //stocker la colonne "Nom_Imprimante" dans une variable
        $this->Nom_Imprimante = $rows[0]['nom_imprimante'];
        // utiliser un focntion setteur pour stocker la colonne "Nom_Imprimante" dans une variable
        $this->setNom_Imprimante($this->Nom_Imprimante);
        // supprimer les colonnes inutiles du tableau (première et deuxième colonne de $rows)
        foreach ($rows as $key => $value) {
            unset($rows[$key]['id']);
            unset($rows[$key]['id_imprimante']);
            unset($rows[$key]['nom_imprimante']);
        }
        return $rows;
    }

    public function getID($id)
    {
        $id = intval($id); // Assurez-vous que l'ID est un nombre entier pour éviter les injections SQL
        $this->setID($id);
    }

    private function setID($id)
    {
        $this->id = $id;
    }

    private function setNom_Imprimante($Nom_Imprimante)
    {
        $this->Nom_Imprimante = $Nom_Imprimante;
    }

    public function getNom_Imprimante()
    {
        return $this->Nom_Imprimante;
    }
}