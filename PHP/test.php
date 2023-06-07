<?php
include ("Connect_BDD.php"); // Assurez-vous que ce chemin d'accès est correct

function getTableNames($conn) {
    $result = $conn->query('SHOW TABLES');
    $tables = [];
    
    if($result === false) {
        die('Erreur de connexion : ' . $conn->error);
    } else {
        while($row = $result->fetch_array()) {
            $tables[] = $row[0];
        }
    }

    return $tables;
}

$tables = getTableNames($conn);
?>
