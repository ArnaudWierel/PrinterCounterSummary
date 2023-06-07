<?php
$host = '10.67.100.111';
$db   = 'glpigroupe';
$user = 'root';
$pass = 'Sbx3390rds!';

// Crée une nouvelle connexion à la base de données
$conn = new mysqli($host, $user, $pass, $db);

// Vérifie si la connexion a réussi
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

echo "Connexion réussie";
?>
