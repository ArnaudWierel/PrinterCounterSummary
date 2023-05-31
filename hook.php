<?php
//============================================================================//
//==    Plugin pour GLPI - Développeur: Snayto (Arnaud Wierel) - ©2023      ==//
//==            https://github.com/ArnaudWierel/PrinterCounterSummary       ==//
//============================================================================//

/**
 * Fonction d'installation du plugin
 * @return boolean
 */
function plugin_printercountersummary_install() 
{
    global $DB;
    
    // Création de la table uniquement lors de la première installation
    if (!$DB->tableExists("glpi_plugin_printercountersummary_profiles")) 
        {
        // requête de création de la table    
        $query = "CREATE TABLE `glpi_plugin_printercountersummary_profiles` (
            `id` int(11) UNSIGNED NOT NULL default '0' COMMENT 'RELATION to glpi_profiles (id)',
            `right` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci default NULL,
            PRIMARY KEY  (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        $DB->query($query) or die($DB->error());

        //création du premier accès nécessaire lors de l'installation du plugin
        $id = $_SESSION['glpiactiveprofile']['id'];
        $query = "INSERT INTO glpi_plugin_printercountersummary_profiles VALUES ('$id','w')";

        $DB->query($query) or die($DB->error());
        }

    // Note : Vous devrez peut-être créer d'autres tables ici pour stocker les informations du relevé d'imprimante sur la page résumée.

    return true;    
}
    
/**
 * Fonction de désinstallation du plugin
 * @return boolean
 */
function plugin_printercountersummary_uninstall() 
{
    global $DB;

    $tables = array("glpi_plugin_printercountersummary_profiles");

    foreach($tables as $table) 
        {$DB->query("DROP TABLE IF EXISTS `$table`;");}
    
    // Note : Vous devrez peut-être supprimer d'autres tables ici lors de la désinstallation du plugin.

    return true;
}    
?>
