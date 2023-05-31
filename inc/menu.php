<?php
/*if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginPrinterCounterSummaryMenu extends CommonGLPI {

    static $rightname = 'plugin_printer_counter_summary';

    static function getTypeName($nb = 0) {
        return __('Rapport Imprimantes', 'printercountersummary');
    }

    static function canCreate() {
        return Session::haveRight(self::$rightname, CREATE);
    }

    static function canView() {
        return Session::haveRight(self::$rightname, READ);
    }

    function showMenu() {
        echo '<div id="printer_counter_summary_menu">';
        // Ici, vous pouvez créer le contenu de votre menu
        echo '</div>';
    }
}
