<?php 
function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {
    if ($item->getType() == 'PluginPrinterCounterSummary') {
        return __('Rapport Imprimantes', 'printercountersummary');
    }
    return '';
}