<?php
include_once "../PHP/Connect_BDD.php";
class CompteurMois
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getMonthlyCounters($id)
    {
        // Récupérez les dates minimales de chaque mois et récupérez l'id_relevé correspondant
        $sql = "
            SELECT MIN(date) AS date, id_relevé
            FROM votre_table
            WHERE imprimante_id = :imprimante_id
            AND DAY(date) = 1
            GROUP BY YEAR(date), MONTH(date)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':imprimante_id', $id);
        $stmt->execute();

        // récupérer les dates et les id_relevé
        $dates = [];
        $idReleves = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dates[] = $row['date'];
            $idReleves[] = $row['id_relevé'];
            echo "Date : {$row['date']}, ID relevé : {$row['id_relevé']}<br>";
        }
        $i = 0;
        foreach ($idReleves as $idReleve) {
            // utilisez les id_relevé pour récupérer les compteurs et les additionner pour chaque mois
            $sql = "
            SELECT SUM(compteur) AS total
            FROM votre_table
            WHERE id_relevé = ?
            AND imprimante_id = ?
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$idReleve, $id]);

            // afficher le total
            $total = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "Total : {$total['total']}<br>";

            // stocker au fur et à mesure les totaux dans un tableau avec les dates comme clés
            $compteurs[$dates[$i]] = $total['total'];
            $i++;
        }
        // faire une soustraction entre les mois(n) et les mois(n+1) pour avoir la consommation mensuelle par exemple pour juillet on fait aout-juillet et mettre le résultat dans un tableau ou comme clef on met le mois et comme valeur la consommation
        $tableau_resultat = [];
        $keys = array_keys($compteurs);
        $i = 0;
        foreach ($compteurs as $compteur) {
            if ($i < count($compteurs) - 1) {
                $tableau_resultat[$keys[$i]] = $compteurs[$keys[$i + 1]] - $compteurs[$keys[$i]];
            }
            $i++;
        }

        echo '<pre>';
        print_r($tableau_resultat);
        echo '</pre>';

        return $tableau_resultat;
    }
}