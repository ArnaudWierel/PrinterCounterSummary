<?php
include_once("save_data.php"); // Changez cela en fonction de l'emplacement de votre deuxième fichier
include_once("../inc/CalMoisCons.class.php"); // Changez cela en fonction de l'emplacement de votre deuxième fichier
$dataSaver = new DataSaver();
$dataSaver->saveData();
$calMoisCons = new CalMoisCons($pdo);
$calMoisCons->main();

// Vous pouvez renvoyer une réponse en écho
echo "Data saved successfully.";
?>