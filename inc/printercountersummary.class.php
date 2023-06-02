<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

class PluginPrinterCounterSummary extends CommonDBTM {
    
    static $rightname = 'plugin_printercountersummary';

    static function getTypeName($nb = 0) {
      return __('Printer Counter Summary', 'printercountersummary');
   }

    // showmenu method is removed, since it's not used.

    static function getMenuContent() {
       $menu = [];
   
       // Menu entry in helpdesk
       $menu['title'] = self::getTypeName(2);
       $menu['page']  = "/plugins/PrinterCounterSummary/front/printercountersummary.php";
       $menu['icon']  = 'fas fa-print';

       return $menu;
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

    function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {
        // Vérifiez le type de l'objet et renvoyez le nom approprié
        switch ($item->getType()) {
            case 'PluginPrinterCounterSummary':
                return __('Printer Counter Summary', 'printercountersummary');
        }
        return '';
    }

    static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {
        // Votre code ici, qui sera exécuté lorsque l'onglet est sélectionné
        switch ($item->getType()) {
            case 'PluginPrinterCounterSummary':
                // Votre code ici
                break;
        }
        return true;
    }
}
