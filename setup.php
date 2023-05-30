<?php
// Check GLPI minimum version and PHP version
if (!defined('GLPI_VERSION')) {
    die("Sorry. You can't access this file directly");
}

function plugin_init_printercountersummary() {
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['printercountersummary'] = true;
    
    // Add a link in the main menu plugins for your plugin
    //$PLUGIN_HOOKS['menu_toadd']['printercountersummary'] = [
    //    'tools' => 'PluginPrintercountersummaryDisplay'
    //];
}

function plugin_version_printercountersummary() {
    return [
        'name'           => 'Printer Counter Summary',
        'version'        => '1.0.0',
        'author'         => 'Arnaud Wierel', 
        'license'        => 'GPLv2+',
        'homepage'       => 'https://github.com/ArnaudWierel/PrinterCounterSummary',
        'minGlpiVersion' => '9.3',
    ];
}

function plugin_printercountersummary_check_prerequisites() {
    // GLPI version check
    if (version_compare(GLPI_VERSION, '9.3', '<')) {
        echo 'This plugin requires GLPI 9.3 or higher.';
        return false;
    }
    return true;
}

function plugin_printercountersummary_check_config() {
    return true;
}

//faire la fonction install sur glpi
function plugin_printercountersummary_install() {
    global $DB;

    $DB->query("CREATE TABLE IF NOT EXISTS `glpi_plugin_printercountersummary` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `date` date NOT NULL,
        `counter` int(11) NOT NULL,
        `printer_id` int(11) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    return true;
}


//Non conforme CSRFFonction inexistante : plugin_PrinterCounterSummary_uninstall
function plugin_printercountersummary_uninstall() {
    global $DB;

    $DB->query("DROP TABLE IF EXISTS `glpi_plugin_printercountersummary`");

    return true;
}