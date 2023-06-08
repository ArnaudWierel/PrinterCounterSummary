<?php
include ("Connect_BDD.php"); // Assurez-vous que ce chemin d'accès est correct

function getTableNames($pdo) {
    $result = $pdo->query('SHOW TABLES');
    $tables = [];
    
    if($result === false) {
        die('Erreur de requête : ' . $pdo->errorInfo()[2]);
    } else {
        while($row = $result->fetch()) {
            $tables[] = $row[0];
        }
    }

    return $tables;
}

$tables = getTableNames($pdo);
?>
