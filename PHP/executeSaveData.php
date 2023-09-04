<?php
/*
__________________________________________________________________________________________________________________________
| ______     _       _            _____                   _            _____                                             |
| | ___ \   (_)     | |          /  __ \                 | |          /  ___|                                            |
| | |_/ / __ _ _ __ | |_ ___ _ __| /  \/ ___  _   _ _ __ | |_ ___ _ __\ `--. _   _ _ __ ___  _ __ ___   __ _ _ __ _   _  |
| |  __/ '__| | '_ \| __/ _ \ '__| |    / _ \| | | | '_ \| __/ _ \ '__|`--. \ | | | '_ ` _ \| '_ ` _ \ / _` | '__| | | | |
| | |  | |  | | | | | ||  __/ |  | \__/\ (_) | |_| | | | | ||  __/ |  /\__/ / |_| | | | | | | | | | | | (_| | |  | |_| | |
| \_|  |_|  |_|_| |_|\__\___|_|   \____/\___/ \__,_|_| |_|\__\___|_|  \____/ \__,_|_| |_| |_|_| |_| |_|\__,_|_|   \__, | |
|                                                                                                                  __/ | |
|                                                                                                                 |___/  |
|___________________________________Version 2.0.0 by Snayto (Arnaud WIEREL) @2023________________________________________|
*/
include_once("save_data.php"); // Changez cela en fonction de l'emplacement de votre deuxième fichier
include_once("../inc/CalMoisCons.class.php"); // Changez cela en fonction de l'emplacement de votre deuxième fichier
$dataSaver = new DataSaver();
$dataSaver->saveData();
$calMoisCons = new CalMoisCons();
$calMoisCons->main();

// Vous pouvez renvoyer une réponse en écho
echo "Data saved successfully.";
?>