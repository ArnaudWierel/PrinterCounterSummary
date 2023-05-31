<?php
//============================================================================//
//==    Plugin pour GLPI - Développeur: Snayto (Arnaud Wierel) - ©2023      ==//
//==            https://github.com/ArnaudWierel/PrinterCounterSummary       ==//
//============================================================================//


/**
 * Fonction de définition de la version du plugin
 * @return array
 */
function plugin_version_printercountersummary() 
{
    return array(
        'name'           => "PrinterCounterSummary",
        'version'        => '1.0.0',
        'author'         => 'Snayto',
        'license'        => 'GPLv2+',
        'homepage'       => 'https://github.com/ArnaudWierel/PrinterCounterSummary',
        'minGlpiVersion' => '10.0.2' // Pour la compatibilité avec GLPI
    );
}

/**
 * Fonction de vérification des prérequis
 * @return boolean
 */
function plugin_printercountersummary_check_prerequisites() 
{
    if (version_compare(GLPI_VERSION, '10.0.2', '>=')) {
        return true;
    }
    echo "Ce plugin nécessite la version 10.0.2 minimum de GLPI.";
    return false;
}        

/**
 * Fonction de vérification de la configuration initiale
 * @param bool $verbose
 * @return boolean
 */
function plugin_printercountersummary_check_config($verbose=false) 
{
    if (true) { // Votre vérification de configuration
        return true;
    }
    if ($verbose) {
        echo 'Installé / non configuré';
    }
    return false;
}

/**
 * Fonction d'initialisation du plugin
 * @global array $PLUGIN_HOOKS
 */
function plugin_init_printercountersummary() 
{
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['PrinterCounterSummary'] = true;
    $PLUGIN_HOOKS['config_page']['printercountersummary'] = 'front/config.form.php';
    Plugin::registerClass('PluginPrinterCounterSummary', array('addtabon' => array('Computer')));
    Plugin::registerClass('PluginPrinterCounterSummaryProfile', array('addtabon' => array('Profile')));
    Plugin::registerClass('PluginPrinterCounterSummaryConfig');
?>