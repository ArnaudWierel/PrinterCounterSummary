<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

class PluginPrinterCounterSummary extends CommonDBTM {
    
    static $rightname = 'plugin_printercountersummary';

    static function getTypeName($nb = 0) {
      return __('Printer Counter Summary', 'printercountersummary');
   }

    //showmenu with the echo
    static function showMenu() {
        echo '<div class="center">';
        echo '<h2>Welcome to the Printer Counter Summary plugin!', 'printercountersummary</h2>';
        echo '</div>';
    }

    static function getMenuContent() {
        return array(
            'title' => self::getTypeName(2),
            'page'  => "/plugins/PrinterCounterSummary/front/printercountersummary.php",
            'icon'  => 'fas fa-print',
            'menu'  => 'plugins'
        );
    }

    // (Optionally) implement access rights 
    function getRights($interface = 'central') {
        switch ($interface) {
            case 'central':
                return [
                    'plugin_printercountersummary' => 'PluginPrinterCounterSummary'
                ];
            case 'profile':
                return [
                    'plugin_printercountersummary' => 'PluginPrinterCounterSummary'
                ];
        }
    }
}
