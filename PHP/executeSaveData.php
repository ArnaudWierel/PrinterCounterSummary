<?php
include_once ("save_data.php"); // Changez cela en fonction de l'emplacement de votre deuxième fichier
$dataSaver = new DataSaver();
$dataSaver->saveData();

// Vous pouvez renvoyer une réponse en écho
echo "Data saved successfully.";
?>
