<?php
$host = 'localhost';
$db   = 'glpi';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

// Configuration des options de connexion
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Crée une nouvelle connexion à la base de données
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Ajoute un script JavaScript pour afficher un message dans la console
    echo '<script>console.log("Connexion établie avec la BDD")</script>';
} catch (\PDOException $e) {
    // Si la connexion échoue, affiche une erreur
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
