<?php
class PluginPrinterCounterSummaryReport extends CommonDBTM {
    static function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {
        return self::createTabEntry('Rapport Imprimantes');
    }

    static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {
        // Ici, vous pouvez créer le contenu de votre nouvel onglet
        echo '<p>Ce texte s\'affiche dans l\'onglet "Rapport Imprimantes"</p>';
        return true;
    }
}
