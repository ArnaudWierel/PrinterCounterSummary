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
|___________________________________Version 1.0.0 by Snayto (Arnaud WIEREL) @2023________________________________________|
*/
include_once('inc/printercountersummary.class.php');

/**
 * Install hook
 *
 * @return boolean
 */
function plugin_printercountersummary_install() {
   global $DB;

   $table = "votre_table";
   // Crée la table pour stocker les informations
   $query = "DROP TABLE IF EXISTS `$table`";
   $DB->query($query) or die("Erreur lors de la suppression de la table $table : ".$DB->error());
   
$query = "CREATE TABLE IF NOT EXISTS `$table` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `imprimante_id` INT UNSIGNED NOT NULL,
      `imprimante_name` VARCHAR(255) NOT NULL,
      `date` TIMESTAMP NOT NULL,
      `id_relevé` INT UNSIGNED NOT NULL,
      `compteur_name` VARCHAR(255) NOT NULL,
      `compteur` INT UNSIGNED NOT NULL,
      `total` INT UNSIGNED NOT NULL,
      PRIMARY KEY (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1";

   $DB->query($query) or die("Erreur lors de la création de la table $table : ".$DB->error());

   return true;
}

/**
 * Uninstall hook
 *
 * @return boolean
 */
function plugin_printercountersummary_uninstall() {
   global $DB;

   // Supprime la table
   $table = "votre_table";
   $query = "DROP TABLE IF EXISTS `$table`";
   $DB->query($query) or die("Erreur lors de la suppression de la table $table : ".$DB->error());
   return true;
}