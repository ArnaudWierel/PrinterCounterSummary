<?php
include ("Connect_BDD.php"); // Assurez-vous que ce chemin d'accès est correct

function getTableNames($pdo) {
    try {
        $result = $pdo->query('SHOW TABLES');
        $tables = [];
        
        while($row = $result->fetch()) {
            $tables[] = $row[0];
        }
        
        return $tables;
    } catch(PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}

$tables = getTableNames($pdo);
?>
