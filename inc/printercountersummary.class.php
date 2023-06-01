<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

class PluginPrinterCounterSummary extends CommonDBTM {
    static function getMenuContent() {
        return array(
            'title' => __("Printer Counter Summary", 'printercountersummary'),
            'page'  => "/plugins/printercountersummary/front/printercountersummary.php",
            'icon'  => 'printercountersummary',
            'menu'  => 'plugins'
        );
    }
}

