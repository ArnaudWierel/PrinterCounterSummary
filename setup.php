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
define('PRINTERCOUNTERSUMMARY_VERSION', '1.0.0');
include_once('inc/printercountersummary.class.php');


/**
 * Init the hooks of the plugins - Needed
 *
 * @return void
 */
function plugin_init_printercountersummary()
{
   global $PLUGIN_HOOKS;

   //required!
   $PLUGIN_HOOKS['csrf_compliant']['PrinterCounterSummary'] = true;
   $PLUGIN_HOOKS['menu_toadd']['printercountersummary'] = array('tools' => 'PluginPrinterCounterSummary');
   Plugin::registerClass('PluginPrinterCounterSummary');
   //some code here, like call to Plugin::registerClass(), populating PLUGIN_HOOKS, ...
}

/**
 * Get the name and the version of the plugin - Needed
 *
 * @return array
 */
function plugin_version_printercountersummary()
{
   return [
      'name' => 'PrinterCounterSummary',
      'version' => '1.0.0',
      'author' => 'Snayto (Arnaud WIEREL)',
      'license' => 'GLPv3',
      'homepage' => 'https://github.com/ArnaudWierel/PrinterCounterSummary',
      'requirements' => [
         'glpi' => [
            'min' => '10.0.2'
         ],
         'php' => [
            'min' => '7.4',
            'max' => '8.19'
         ]
      ]
   ];
}

/**
 * Optional : check prerequisites before install : may print errors or add to message after redirect
 *
 * @return boolean
 */
function plugin_printercountersummary_check_prerequisites()
{
   // check the glpi version
   if (version_compare(GLPI_VERSION, '10.0.2', 'lt') || version_compare(PHP_VERSION, '7.4', 'lt')) {
      echo "This plugin requires GLPI 10.0.2 and PHP between 7.4 and 8.19";
      return false;
   }
   return true;
}

/**
 * Check configuration process for plugin : need to return true if succeeded
 * Can display a message only if failure and $verbose is true
 *
 * @param boolean $verbose Enable verbosity. Default to false
 *
 * @return boolean
 */
function plugin_printercountersummary_check_config($verbose = false)
{
   if (true) { // Your configuration check
      return true;
   }

   if ($verbose) {
      echo "Installed, but not configured";
   }
   return false;
}

/**
 * Optional: defines plugin options.
 *
 * @return array
 */
function plugin_printercountersummary_options()
{
   return [
      Plugin::OPTION_AUTOINSTALL_DISABLED => true,
   ];
}